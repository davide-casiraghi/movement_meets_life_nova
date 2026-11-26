<?php

namespace Tests\Feature\Gestionale;

use App\Enums\AppointmentStatus;
use App\Enums\VatCode;
use App\Filament\Pages\Calendario;
use App\Models\AccessLog;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use Carbon\CarbonImmutable;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CalendarioTest extends TestCase
{
    use RefreshDatabase;

    private User $pro;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        Filament::setCurrentPanel(Filament::getPanel('gestionale'));
        \Filament\Support\Facades\FilamentTimezone::set('Europe/Rome');

        // Monday 30 November 2026, 08:00 in Rome (07:00 UTC)
        Carbon::setTestNow(CarbonImmutable::parse('2026-11-30 08:00', 'Europe/Rome'));

        config(['gestionale.working_hours' => [
            1 => [['09:00', '13:00']], 2 => [['09:00', '13:00']], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [],
        ]]);

        $this->pro = User::factory()->create(['email' => 'fisio@example.test']);
        $this->pro->assignRole(User::PHYSIOTHERAPIST_ROLE);
        $this->actingAs($this->pro);

        Service::factory()->create(['name' => 'Terapia manuale', 'price' => '50.00', 'duration_minutes' => 30, 'color' => Service::COLORS[6], 'vat_code' => VatCode::N4]);
        Service::factory()->create(['name' => 'Vecchio servizio', 'archived_at' => now()]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    #[Test]
    public function thePageRendersAndOnlyPhysiotherapistsCanOpenIt(): void
    {
        Livewire::test(Calendario::class)->assertOk()->assertSee('Aggiungi collega');

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');
        $this->actingAs($admin)->get(Calendario::getUrl())->assertForbidden();
    }

    #[Test]
    public function theTitleMenuOffersTheActiveServicesOfThePriceList(): void
    {
        Livewire::test(Calendario::class)
            ->mountAction('createEvent')
            ->assertMountedActionModalSee('Terapia manuale')
            ->assertMountedActionModalSee('50,00 €')
            ->assertMountedActionModalSee('(30min)')
            ->assertMountedActionModalDontSee('Vecchio servizio');
    }

    #[Test]
    public function choosingAServiceFillsPriceColourAndEndAndTheEventIsSavedInUtc(): void
    {
        $patient = Patient::factory()->create();

        Livewire::test(Calendario::class)
            ->mountAction('createEvent', ['start' => '2026-12-01T10:00:00+01:00', 'end' => '2026-12-01T10:15:00+01:00'])
            // Form state is in Rome time
            ->assertSet('mountedActions.0.data.starts_at', '2026-12-01 10:00:00')
            ->assertSet('mountedActions.0.data.ends_at', '2026-12-01 11:00:00')
            ->setActionData(['title' => 'Terapia manuale'])
            ->assertSet('mountedActions.0.data.price', '50,00')
            ->assertSet('mountedActions.0.data.color', Service::COLORS[6])
            ->assertSet('mountedActions.0.data.ends_at', '2026-12-01 10:30:00')
            ->setActionData(['patient_id' => $patient->id])
            ->callMountedAction()
            ->assertHasNoActionErrors();

        $event = Appointment::sole();
        $this->assertSame('2026-12-01 09:00:00', $event->starts_at->format('Y-m-d H:i:s')); // UTC
        $this->assertSame('2026-12-01 09:30:00', $event->ends_at->format('Y-m-d H:i:s'));
        $this->assertSame('50.00', $event->price);
        $this->assertSame($this->pro->id, $event->user_id);
        $this->assertNotNull($event->service_id);
        $this->assertDatabaseHas('access_logs', ['event' => 'created', 'subject_id' => $event->id]);
    }

    #[Test]
    public function findAvailabilityShowsTheFreeSlotsAndAClickSetsTheTime(): void
    {
        Appointment::factory()->create([
            'user_id' => $this->pro->id,
            'starts_at' => CarbonImmutable::parse('2026-11-30 09:00', 'Europe/Rome')->utc(),
            'ends_at' => CarbonImmutable::parse('2026-11-30 12:10', 'Europe/Rome')->utc(),
        ]);

        Livewire::test(Calendario::class)
            ->mountAction('createEvent', ['start' => '2026-12-01T10:00:00+01:00', 'end' => '2026-12-01T10:30:00+01:00'])
            ->assertMountedActionModalDontSee('Raggruppa per')
            ->callAction(TestAction::make('findAvailability')->schemaComponent('when', schema: 'mountedActionSchema0'))
            ->assertSet('mountedActions.0.data.show_availability', true)
            ->assertSet('mountedActions.0.data.av_duration', '30')
            ->assertMountedActionModalSee('Raggruppa per')
            ->assertMountedActionModalSee('Oggi 30 nov')
            ->assertMountedActionModalSee('12:10')          // right after the existing appointment
            ->assertMountedActionModalSee('Domani 1 dic')
            // a click on a slot
            ->call('pickAvailabilitySlot', '2026-12-01 09:00:00', '2026-12-01 09:30:00', $this->pro->id)
            ->assertSet('mountedActions.0.data.starts_at', '2026-12-01 09:00:00')
            ->assertSet('mountedActions.0.data.ends_at', '2026-12-01 09:30:00')
            ->assertSet('mountedActions.0.data.av_days', 14)
            ->assertSet('mountedActions.0.data.av_group', 'day')
            ->setActionData(['title' => 'Prima visita'])
            ->callMountedAction()
            ->assertHasNoActionErrors();

        $this->assertSame('2026-12-01 08:00:00', Appointment::where('title', 'Prima visita')->sole()->starts_at->format('Y-m-d H:i:s'));
    }

    #[Test]
    public function recurringEventsCreateOneEventPerOccurrence(): void
    {
        Livewire::test(Calendario::class)
            ->mountAction('createEvent', ['start' => '2026-12-01T10:00:00+01:00', 'end' => '2026-12-01T11:00:00+01:00'])
            ->setActionData([
                'title' => 'Ciclo di trattamenti',
                'recurring' => true,
                'recurrence_frequency' => 'weekly',
                'recurrence_until' => '2026-12-22',
            ])
            ->callMountedAction()
            ->assertHasNoActionErrors();

        $events = Appointment::orderBy('starts_at')->get();
        $this->assertCount(4, $events);
        $this->assertSame(1, $events->pluck('recurrence_group')->unique()->count());
        $this->assertSame('2026-12-22 09:00:00', $events->last()->starts_at->format('Y-m-d H:i:s'));
    }

    #[Test]
    public function editingDeletingAndMovingEvents(): void
    {
        $event = Appointment::factory()->create([
            'user_id' => $this->pro->id,
            'title' => 'TENS',
            'notes' => 'Nota riservata',
            'starts_at' => CarbonImmutable::parse('2026-12-01 10:00', 'Europe/Rome')->utc(),
            'ends_at' => CarbonImmutable::parse('2026-12-01 10:30', 'Europe/Rome')->utc(),
        ]);

        Livewire::test(Calendario::class)
            ->mountAction('editEvent', ['id' => $event->id])
            ->assertSet('mountedActions.0.data.title', 'TENS')
            ->assertSet('mountedActions.0.data.notes', 'Nota riservata')
            ->assertSet('mountedActions.0.data.starts_at', '2026-12-01 10:00:00')
            ->setActionData(['status' => AppointmentStatus::Confirmed->value])
            ->callMountedAction()
            ->assertHasNoActionErrors();

        $this->assertSame(AppointmentStatus::Confirmed, $event->fresh()->status);
        $this->assertDatabaseHas('access_logs', ['event' => 'viewed', 'subject_id' => $event->id, 'subject_type' => $event->getMorphClass()]);

        Livewire::test(Calendario::class)->call('moveEvent', $event->id, '2026-12-01T11:00:00+01:00', '2026-12-01T11:45:00+01:00');
        $this->assertSame('2026-12-01 10:00:00', $event->fresh()->starts_at->format('Y-m-d H:i:s'));
        $this->assertSame('2026-12-01 10:45:00', $event->fresh()->ends_at->format('Y-m-d H:i:s'));

        Livewire::test(Calendario::class)
            ->mountAction('editEvent', ['id' => $event->id])
            ->callAction(TestAction::make('deleteEvent'));
        $this->assertSoftDeleted($event);
    }

    #[Test]
    public function getEventsReturnsTheWeekInRomeTimeAndHidesCancelledOnes(): void
    {
        $patient = Patient::factory()->create(['first_name' => 'Maria', 'last_name' => 'Rossi']);
        Appointment::factory()->create([
            'patient_id' => $patient->id,
            'title' => 'Terapia manuale',
            'starts_at' => CarbonImmutable::parse('2026-12-01 10:00', 'Europe/Rome')->utc(),
            'ends_at' => CarbonImmutable::parse('2026-12-01 10:30', 'Europe/Rome')->utc(),
        ]);
        Appointment::factory()->create(['status' => AppointmentStatus::Cancelled]);

        $events = Livewire::test(Calendario::class)
            ->instance()
            ->getEvents('2026-11-30T00:00:00+01:00', '2026-12-07T00:00:00+01:00');

        $this->assertCount(1, $events);
        $this->assertSame('Rossi Maria · Terapia manuale', $events[0]['title']);
        $this->assertSame('2026-12-01T10:00:00+01:00', $events[0]['start']);
    }

    #[Test]
    public function movingTheStartKeepsTheDurationAndTheChosenSlotIsHighlighted(): void
    {
        Livewire::test(Calendario::class)
            ->mountAction('createEvent', ['start' => '2026-12-01T10:00:00+01:00', 'end' => '2026-12-01T11:30:00+01:00'])
            ->set('mountedActions.0.data.starts_at', '2026-12-01 12:00:00')
            ->assertSet('mountedActions.0.data.ends_at', '2026-12-01 13:30:00')
            ->callAction(TestAction::make('findAvailability')->schemaComponent('when', schema: 'mountedActionSchema0'))
            ->call('pickAvailabilitySlot', '2026-12-01 09:30:00', '2026-12-01 11:00:00', $this->pro->id)
            ->assertMountedActionModalSeeHtml('gest-slot gest-slot-selected">09:30<');
    }
}
