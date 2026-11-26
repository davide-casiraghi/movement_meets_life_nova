<?php

namespace Tests\Feature\Gestionale;

use App\Enums\VatCode;
use App\Filament\Resources\Services\Pages\ManageServices;
use App\Models\Service;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ListinoPrezziTest extends TestCase
{
    use RefreshDatabase;

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
    public function itCreatesAServiceAcceptingAnItalianPrice(): void
    {
        Livewire::test(ManageServices::class)
            ->assertSee('I servizi del tuo studio, con durata e prezzo')
            ->callAction('create', [
                'name' => 'Trattamento ILM',
                'code' => 'ILM-60',
                'color' => Service::COLORS[5],
                'duration_minutes' => 60,
                'vat_code' => VatCode::N4->value,
                'price' => '50,02',
            ])
            ->assertHasNoActionErrors();

        $service = Service::where('name', 'Trattamento ILM')->firstOrFail();
        $this->assertSame('50.02', $service->price);
        $this->assertSame(VatCode::N4, $service->vat_code);
        $this->assertSame(60, $service->duration_minutes);
    }

    #[Test]
    public function nameVatCodeAndPriceAreRequired(): void
    {
        Livewire::test(ManageServices::class)
            ->callAction('create', ['price' => '12,345'])
            ->assertHasActionErrors(['name' => 'required', 'vat_code' => 'required', 'price' => 'regex']);
    }

    #[Test]
    public function itListsActiveServicesAndFiltersArchivedOnes(): void
    {
        $active = Service::factory()->create(['name' => 'TENS', 'code' => 'TENS-30']);
        $archived = Service::factory()->create(['name' => 'Vecchio', 'archived_at' => now()]);

        Livewire::test(ManageServices::class)
            ->assertCanSeeTableRecords([$active])
            ->assertCanNotSeeTableRecords([$archived])
            ->filterTable('status', 'archived')
            ->assertCanSeeTableRecords([$archived])
            ->assertCanNotSeeTableRecords([$active])
            ->filterTable('status', 'all')
            ->assertCanSeeTableRecords([$active, $archived]);

        Livewire::test(ManageServices::class)
            ->searchTable('TENS-30')
            ->assertCanSeeTableRecords([$active]);
    }

    #[Test]
    public function itArchivesRestoresAndBulkArchives(): void
    {
        [$a, $b, $c] = Service::factory()->count(3)->create()->all();

        Livewire::test(ManageServices::class)
            ->callAction(TestAction::make('archive')->table($a))
            ->assertHasNoActionErrors();
        $this->assertTrue($a->fresh()->isArchived());

        Livewire::test(ManageServices::class)
            ->filterTable('status', 'archived')
            ->callAction(TestAction::make('unarchive')->table($a));
        $this->assertFalse($a->fresh()->isArchived());

        Livewire::test(ManageServices::class)
            ->selectTableRecords([$b->getKey(), $c->getKey()])
            ->callAction(TestAction::make('archiveSelected')->table()->bulk());
        $this->assertTrue($b->fresh()->isArchived());
        $this->assertTrue($c->fresh()->isArchived());
        $this->assertFalse($a->fresh()->isArchived());
    }

    #[Test]
    public function itDuplicatesAService(): void
    {
        $service = Service::factory()->create(['name' => 'Terapia manuale', 'price' => '50.00']);

        Livewire::test(ManageServices::class)
            ->callAction(TestAction::make('replicate')->table($service))
            ->assertHasNoActionErrors();

        $copy = Service::where('name', 'Terapia manuale (copia)')->firstOrFail();
        $this->assertSame('50.00', $copy->price);
        $this->assertNotSame($service->id, $copy->id);
    }

    #[Test]
    public function itEditsAService(): void
    {
        $service = Service::factory()->create(['price' => '20.00']);

        Livewire::test(ManageServices::class)
            ->callAction(TestAction::make('edit')->table($service), ['price' => '25,50'])
            ->assertHasNoActionErrors();

        $this->assertSame('25.50', $service->fresh()->price);
    }

    #[Test]
    public function vatCodesExposeRateAndNature(): void
    {
        $this->assertSame(22, VatCode::Vat22->rate());
        $this->assertNull(VatCode::Vat22->nature());
        $this->assertSame(0, VatCode::N4->rate());
        $this->assertSame('N4', VatCode::N4->nature());
        $this->assertStringStartsWith('0% - N6.9 - Inversione contabile', VatCode::N6_9->getLabel());
    }

    #[Test]
    public function inTheArchiveTheBulkActionRestoresInsteadOfArchiving(): void
    {
        [$a, $b] = Service::factory()->count(2)->create(['archived_at' => now()])->all();
        $active = Service::factory()->create();

        Livewire::test(ManageServices::class)
            ->assertActionVisible(TestAction::make('archiveSelected')->table()->bulk())
            ->assertActionHidden(TestAction::make('unarchiveSelected')->table()->bulk());

        Livewire::test(ManageServices::class)
            ->filterTable('status', 'archived')
            ->assertActionHidden(TestAction::make('archiveSelected')->table()->bulk())
            ->assertActionVisible(TestAction::make('unarchiveSelected')->table()->bulk())
            ->selectTableRecords([$a->getKey(), $b->getKey()])
            ->callAction(TestAction::make('unarchiveSelected')->table()->bulk())
            ->assertHasNoActionErrors();

        $this->assertFalse($a->fresh()->isArchived());
        $this->assertFalse($b->fresh()->isArchived());
        $this->assertFalse($active->fresh()->isArchived());
    }
}
