<?php

namespace Tests\Feature\Gestionale;

use App\Enums\InvoiceType;
use App\Enums\PaymentMethod;
use App\Enums\VatCode;
use App\Enums\WithholdingReason;
use App\Enums\WithholdingType;
use App\Filament\Pages\Contabilita;
use App\Filament\Resources\Invoices\Pages\CreateInvoice;
use App\Models\AccessLog;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContabilitaTest extends TestCase
{
    use RefreshDatabase;

    private Patient $patient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        Carbon::setTestNow('2026-11-26 10:00:00');
        Filament::setCurrentPanel(Filament::getPanel('gestionale'));

        $user = User::factory()->create();
        $user->assignRole(User::PHYSIOTHERAPIST_ROLE);
        $this->actingAs($user);

        $this->patient = Patient::factory()->create(['first_name' => 'Mario', 'last_name' => 'Rossi', 'birth_date' => '1987-10-05']);
        Service::factory()->create(['name' => 'Terapia manuale', 'price' => 50, 'vat_code' => VatCode::N2_2]);
    }

    #[Test]
    public function thePageShowsTheSummaryTabsAndInvoices(): void
    {
        $this->invoice(['number' => 1, 'total' => 152, 'paid' => true]);
        $this->invoice(['number' => 2, 'total' => 50, 'paid' => false]);

        Livewire::test(Contabilita::class)
            ->assertSee(['Contabilità', 'Nuova fattura', 'Novembre 2026', '(Mese corrente)', 'Informazioni generali', '2 documenti emessi', '202,00 €', '152,00 €', 'Da incassare: 1', '75,2% del fatturato'])
            ->assertSee(['Fatture Attive', 'Fatture Passive', 'Proforma', 'Sedute da saldare', 'Spese', 'Cerca cliente...', '1/2026', 'Rossi Mario'])
            ->set('tab', 'expenses')
            ->assertSee('Work in progress');
    }

    #[Test]
    public function itCreatesAnInvoiceFromThePriceList(): void
    {
        Livewire::test(CreateInvoice::class)
            ->assertSee(['Nuovo documento contabile', 'Generali', 'Prestazione', 'Tassazione', 'Coordinate bancarie', 'Altro', 'Crea documento'])
            ->assertSchemaStateSet(['number' => 1, 'payment_method' => PaymentMethod::Cash, 'type' => InvoiceType::Health])
            ->fillForm(['patient_id' => $this->patient->id, 'paid' => true, 'stamp_enabled' => true])
            ->fillForm(fn (array $state) => ['items' => array_map(fn () => ['description' => 'Terapia manuale', 'quantity' => '2', 'discount' => '0'], $state['items'])])
            ->assertSee('100,00 €')
            ->call('create')
            ->assertHasNoFormErrors();

        $invoice = Invoice::with('items')->firstOrFail();
        $this->assertSame('1/2026', $invoice->display_number);
        $this->assertTrue($invoice->paid);
        $this->assertSame('2026-11-26', $invoice->paid_on->format('Y-m-d'));
        $this->assertSame('50.00', $invoice->items->first()->unit_price);
        $this->assertSame(VatCode::N2_2, $invoice->items->first()->vat_code);
        $this->assertSame('100.00', $invoice->items->first()->total);
        $this->assertSame('96.15', $invoice->taxable_amount);
        $this->assertSame('102.00', $invoice->total);
        $this->assertSame('Rossi Mario', $invoice->customer['name']);
        $this->assertStringContainsString('Legge n. 190/2014', $invoice->central_text);

        // Encrypted at rest; creation logged.
        $this->assertStringNotContainsString('Terapia', DB::table('invoice_items')->value('description'));
        $this->assertStringNotContainsString('Rossi', DB::table('invoices')->value('customer'));
        $this->assertTrue(AccessLog::where('subject_type', Invoice::class)->where('event', 'created')->exists());

        // The next one gets number 2.
        Livewire::test(CreateInvoice::class)->assertSchemaStateSet(['number' => 2]);
    }

    #[Test]
    public function numbersAreUniquePerYearAndRequiredFieldsAreChecked(): void
    {
        $this->invoice(['number' => 1]);

        Livewire::test(CreateInvoice::class)
            ->fillForm(['number' => 1, 'paid' => true, 'paid_on' => null])
            ->call('create')
            ->assertHasFormErrors(['patient_id', 'number', 'paid_on']);

        // Another year starts again from 1.
        Livewire::test(CreateInvoice::class)
            ->fillForm(['issued_on' => '2027-01-02'])
            ->assertSchemaStateSet(['number' => 1]);
    }

    #[Test]
    public function centralTextTemplateAndAppointmentsReport(): void
    {
        Appointment::factory()->create(['patient_id' => $this->patient->id, 'title' => 'Terapia manuale', 'starts_at' => '2026-11-20 09:00:00', 'ends_at' => '2026-11-20 09:30:00']);

        Livewire::test(CreateInvoice::class)
            ->fillForm(['central_text' => '', 'patient_id' => $this->patient->id])
            ->callAction(TestAction::make('chooseCentralText')->schemaComponent('central_text', schema: 'form'), ['template' => 0])
            ->assertSchemaStateSet(fn (array $state) => $this->assertStringContainsString('Legge n. 190/2014', $state['central_text']) ?? [])
            ->callAction(TestAction::make('appointmentsReport')->schemaComponent('notes', schema: 'form'))
            ->assertSchemaStateSet(['notes' => "Appuntamenti:\n- 20/11/2026 10:00 Terapia manuale"]);
    }

    #[Test]
    public function withholdingTaxShowsItsFieldsAndUsesTheBase(): void
    {
        Livewire::test(CreateInvoice::class)
            ->assertDontSee('Causale Pagamento')
            ->fillForm(['patient_id' => $this->patient->id, 'contribution_included' => false])
            ->fillForm(fn (array $state) => ['items' => array_map(fn () => ['description' => 'Terapia manuale', 'quantity' => '2', 'discount' => '0'], $state['items'])])
            ->fillForm(['withholding_enabled' => true])
            ->assertSee(['Tipo Ritenuta', 'Causale Pagamento', 'Aliquota (%)', 'Base Imponibile (€)', 'A - Prestazioni di lavoro autonomo'])
            // Proposed base: 100 € of fees + 4 € of INPS rivalsa.
            ->assertSchemaStateSet(['withholding_base' => '104,00', 'withholding_rate' => 20])
            ->fillForm(['withholding_type' => 'RT01', 'withholding_reason' => 'A', 'withholding_base' => '100,00'])
            ->call('create')
            ->assertHasNoFormErrors();

        $invoice = Invoice::firstOrFail();
        $this->assertSame(WithholdingType::Individuals, $invoice->withholding_type);
        $this->assertSame(WithholdingReason::A, $invoice->withholding_reason);
        $this->assertSame('100.00', $invoice->withholding_base);
        $this->assertSame('20.00', $invoice->withholding_amount);
        $this->assertSame('84.00', $invoice->net_due);

        // A required base when the withholding is on.
        Livewire::test(CreateInvoice::class)
            ->fillForm(['withholding_enabled' => true, 'withholding_base' => ''])
            ->call('create')
            ->assertHasFormErrors(['withholding_base']);
    }

    #[Test]
    public function onlyPhysiotherapistsSeeTheAccounting(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(Contabilita::getUrl())->assertForbidden();
    }

    private function invoice(array $attributes): Invoice
    {
        return Invoice::create([
            'patient_id' => $this->patient->id,
            'type' => 'health',
            'year' => 2026,
            'issued_on' => '2026-11-10',
            'payment_method' => 'cash',
            'tax_regime' => 'RF19',
            'customer' => ['name' => 'Rossi Mario'],
            ...$attributes,
        ]);
    }
}
