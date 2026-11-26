<?php

namespace Tests\Feature\Gestionale;

use App\Enums\PersonType;
use App\Enums\RepresentativeRole;
use App\Enums\Sex;
use App\Filament\Resources\Patients\Pages\CreatePatient;
use App\Filament\Resources\Patients\Pages\EditPatient;
use App\Filament\Resources\Patients\Pages\ListPatients;
use App\Filament\Resources\Patients\Pages\ViewPatient;
use App\Models\AccessLog;
use App\Models\Patient;
use App\Models\PatientRepresentative;
use App\Models\User;
use App\Support\CodiceFiscale;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PazientiTest extends TestCase
{
    use RefreshDatabase;

    private const REQUIRED = [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'sex' => 'M',
        'fiscal_code' => 'rssmra80a01h501u',
        'address' => 'Via Roma 10',
        'city' => 'Roma',
        'province' => 'rm',
        'postal_code' => '00100',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        Filament::setCurrentPanel(Filament::getPanel('gestionale'));

        $user = User::factory()->create();
        $user->assignRole(User::PHYSIOTHERAPIST_ROLE);
        $this->actingAs($user);
    }

    #[Test]
    public function fiscalCodeCheckCharacterIsVerified(): void
    {
        $this->assertTrue(CodiceFiscale::isValidIndividual('RSSMRA80A01H501U'));
        $this->assertTrue(CodiceFiscale::isValidIndividual(' rssmra80a01h501u '));
        $this->assertFalse(CodiceFiscale::isValidIndividual('RSSMRA80A01H501X'));
        $this->assertFalse(CodiceFiscale::isValidIndividual('RSSMRA80A01H501'));
        $this->assertTrue(CodiceFiscale::isValidCompany('12345678901'));
        $this->assertFalse(CodiceFiscale::isValidCompany('1234567890'));
    }

    #[Test]
    public function itCreatesAPatientWithALegalRepresentative(): void
    {
        Livewire::test(CreatePatient::class)
            ->assertSee(['Nuovo paziente', 'Raccogli tutte le informazioni principali del paziente.', 'Generali', 'Contatti', 'Domicilio', 'Dati sanitari', 'Rappresentanti legali', 'Nessun rappresentante legale'])
            ->assertSchemaStateSet(['person_type' => PersonType::Individual, 'nationality' => 'IT', 'address_country' => 'IT', 'ts_transmission' => true])
            ->fillForm([
                ...self::REQUIRED,
                'birth_date' => '2015-03-01',
                'birth_city' => 'Roma',
                'birth_province' => 'rm',
                'mobile' => '+39 330 1234411',
                'email' => 'mario@example.test',
                'notes' => 'Preferisce il mattino',
                'id_card_number' => 'ca1234567',
                'health_card_number' => '80380000000000000000',
                'ts_transmission' => '0',
            ])
            ->callAction(
                TestAction::make('addRepresentative')->schemaComponent('representatives-section', schema: 'form'),
                [
                    'role' => RepresentativeRole::Parent->value,
                    'first_name' => 'Anna',
                    'last_name' => 'Bianchi',
                    'fiscal_code' => 'bnchnn85c41h501x',
                    'mobile' => '+39 333 1234567',
                    'document_type' => 'identity_card',
                    'document_number' => 'CA12345AB',
                    'document_issued_at' => '2020-01-10',
                    'document_expires_at' => '2030-01-10',
                ],
            )
            ->assertHasNoActionErrors()
            ->assertSee('Genitore · Anna Bianchi')
            ->assertDontSee('Nessun rappresentante legale')
            ->call('create')
            ->assertHasNoFormErrors();

        $patient = Patient::firstOrFail();
        $this->assertSame('RSSMRA80A01H501U', $patient->fiscal_code);
        $this->assertSame('RM', $patient->province);
        $this->assertSame(Sex::Male, $patient->sex);
        $this->assertSame('CA1234567', $patient->id_card_number);
        $this->assertFalse($patient->ts_transmission);
        $this->assertSame('Preferisce il mattino', $patient->notes);

        $representative = $patient->representatives()->firstOrFail();
        $this->assertSame(RepresentativeRole::Parent, $representative->role);
        $this->assertSame('BNCHNN85C41H501X', $representative->fiscal_code);
        $this->assertSame('CA12345AB', $representative->document_number);
        $this->assertSame('2030-01-10', $representative->document_expires_at->format('Y-m-d'));

        // Encrypted at rest.
        $raw = DB::table('patients')->where('id', $patient->id)->first();
        $this->assertStringNotContainsString('RSSMRA', $raw->fiscal_code);
        $this->assertStringNotContainsString('Via Roma', $raw->address);
        $this->assertStringNotContainsString('CA12345AB', DB::table('patient_representatives')->value('document_number'));
    }

    #[Test]
    public function requiredFieldsAndFormatsAreChecked(): void
    {
        Livewire::test(CreatePatient::class)
            ->fillForm(['fiscal_code' => 'RSSMRA80A01H501X', 'postal_code' => '123', 'province' => 'Roma', 'health_card_number' => '123', 'vat_number' => '123'])
            ->call('create')
            ->assertHasFormErrors(['first_name', 'last_name', 'sex', 'fiscal_code', 'address', 'city', 'province', 'postal_code', 'health_card_number', 'vat_number']);

        // Abroad: no province, free postal code; a foreign fiscal code is not checked.
        Livewire::test(CreatePatient::class)
            ->fillForm([...self::REQUIRED, 'nationality' => 'DE', 'fiscal_code' => 'DE123456', 'address_country' => 'DE', 'province' => null, 'postal_code' => '10115'])
            ->call('create')
            ->assertHasNoFormErrors();
    }

    #[Test]
    public function sexCanBeOther(): void
    {
        Livewire::test(CreatePatient::class)
            ->assertSee('Altro')
            ->fillForm([...self::REQUIRED, 'sex' => 'X'])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(Sex::Other, Patient::firstOrFail()->sex);
    }

    #[Test]
    public function aCompanyNeedsOnlyItsNameAndAnElevenDigitFiscalCode(): void
    {
        Livewire::test(CreatePatient::class)
            ->fillForm(['person_type' => 'company'])
            ->assertSee('Ragione sociale')
            ->fillForm([...self::REQUIRED, 'person_type' => 'company', 'first_name' => null, 'sex' => null, 'last_name' => 'Polisportiva Rossi ASD', 'fiscal_code' => '12345678901'])
            ->call('create')
            ->assertHasNoFormErrors();

        $company = Patient::firstOrFail();
        $this->assertSame(PersonType::Company, $company->person_type);
        $this->assertSame('Polisportiva Rossi ASD', $company->full_name);
    }

    #[Test]
    public function editingKeepsTheEncryptedFieldsAndUpdatesRepresentatives(): void
    {
        $patient = Patient::factory()->create(['allergies' => 'Lattice', 'notes' => 'Nota riservata']);
        $representative = $patient->representatives()->create([
            'role' => 'guardian', 'first_name' => 'Luca', 'last_name' => 'Verdi',
            'fiscal_code' => 'VRDLCU70A01H501X', 'document_number' => 'AB123',
        ]);

        Livewire::test(EditPatient::class, ['record' => $patient->getRouteKey()])
            // The encrypted fields are loaded into the form (they are hidden from toArray()).
            ->assertSchemaStateSet(['allergies' => 'Lattice', 'notes' => 'Nota riservata', 'fiscal_code' => 'RSSMRA80A01H501U'])
            ->assertSee('Tutore · Luca Verdi')
            ->callAction(
                TestAction::make('editRepresentative')
                    ->schemaComponent('representatives-section.representatives', schema: 'form')
                    ->arguments(['item' => "record-{$representative->id}"]),
                ['mobile' => '+39 320 0000000'],
            )
            ->assertHasNoActionErrors()
            ->fillForm(['city' => 'Milano', 'province' => 'MI', 'postal_code' => '20100'])
            ->call('save')
            ->assertHasNoFormErrors();

        $patient->refresh();
        $this->assertSame('Lattice', $patient->allergies);
        $this->assertSame('Nota riservata', $patient->notes);
        $this->assertSame('Milano', $patient->city);

        $representative->refresh();
        $this->assertSame('+39 320 0000000', $representative->mobile);
        $this->assertSame('VRDLCU70A01H501X', $representative->fiscal_code);
        $this->assertSame('AB123', $representative->document_number);
        $this->assertTrue(AccessLog::where('subject_type', PatientRepresentative::class)->where('event', 'updated')->exists());

        // Removing the last representative.
        Livewire::test(EditPatient::class, ['record' => $patient->getRouteKey()])
            ->callAction(
                TestAction::make('delete')
                    ->schemaComponent('representatives-section.representatives', schema: 'form')
                    ->arguments(['item' => "record-{$representative->id}"]),
            )
            ->assertSee('Nessun rappresentante legale')
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(0, $patient->representatives()->count());
    }

    #[Test]
    public function theListShowsActiveAndArchivedPatients(): void
    {
        $active = Patient::factory()->create(['last_name' => 'Attivo', 'mobile' => '3201112233', 'ts_transmission' => true]);
        $archived = Patient::factory()->create(['last_name' => 'Archiviato', 'ts_transmission' => false]);
        $archived->delete();

        Livewire::test(ListPatients::class)
            ->assertSee(['#1 Totale pazienti', 'Aggiungi paziente', 'Cerca paziente...', 'RSSMRA80A01H501U', 'Cell:'])
            ->assertCanSeeTableRecords([$active, $archived])
            ->set('status', 'active')
            ->assertCanSeeTableRecords([$active])
            ->assertCanNotSeeTableRecords([$archived])
            ->set('status', 'archived')
            ->assertCanSeeTableRecords([$archived])
            ->assertCanNotSeeTableRecords([$active])
            ->set('status', 'all')
            ->searchTable('3201112233')
            ->assertCanSeeTableRecords([$active])
            ->assertCanNotSeeTableRecords([$archived]);

        Livewire::test(ListPatients::class)
            ->filterTable('ts_transmission', false)
            ->assertCanSeeTableRecords([$archived])
            ->assertCanNotSeeTableRecords([$active]);
    }

    #[Test]
    public function thePatientPageShowsTheRegistryAndIsLogged(): void
    {
        $patient = Patient::factory()->create(['last_name' => 'Rossi', 'first_name' => 'Mario', 'health_card_number' => '80380000000000000001']);
        $patient->representatives()->create(['role' => 'parent', 'first_name' => 'Anna', 'last_name' => 'Bianchi', 'fiscal_code' => 'X1']);

        Livewire::test(ViewPatient::class, ['record' => $patient->getRouteKey()])
            ->assertSee(['Rossi Mario', 'Italia', '80380000000000000001', 'Anna Bianchi', 'Genitore']);

        $this->assertTrue(AccessLog::where('subject_type', Patient::class)->where('event', 'viewed')->exists());
    }
}
