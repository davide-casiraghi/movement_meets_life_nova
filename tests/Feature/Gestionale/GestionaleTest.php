<?php

namespace Tests\Feature\Gestionale;

use App\Filament\Resources\AccessLogs\Pages\ListAccessLogs;
use App\Filament\Resources\Patients\Pages\CreatePatient;
use App\Filament\Resources\Patients\Pages\EditPatient;
use App\Filament\Resources\Patients\Pages\ListPatients;
use App\Filament\Resources\Patients\RelationManagers\TreatmentSessionsRelationManager;
use App\Filament\Resources\TreatmentSessions\Pages\CreateTreatmentSession;
use App\Filament\Resources\TreatmentSessions\Pages\ListTreatmentSessions;
use App\Filament\Resources\Patients\Pages\ViewPatient;
use App\Filament\Resources\Patients\PatientResource;
use App\Filament\Resources\TreatmentSessions\Pages\ViewTreatmentSession;
use App\Models\AccessLog;
use App\Models\Patient;
use App\Models\TreatmentSession;
use App\Models\User;
use App\Models\UserProfile;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GestionaleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        Filament::setCurrentPanel(Filament::getPanel('gestionale'));
    }

    private function physiotherapist(): User
    {
        $user = User::factory()->create();
        $user->assignRole(User::PHYSIOTHERAPIST_ROLE);

        return $user;
    }

    #[Test]
    public function clinicalFieldsAreEncryptedInTheDatabase(): void
    {
        $patient = Patient::factory()->create(['medical_history' => 'Ernia L4-L5', 'fiscal_code' => 'RSSMRA80A01H501U']);
        $session = TreatmentSession::factory()->for($patient)->create(['assessment' => 'Dolore irradiato']);

        $patientRow = DB::table('patients')->find($patient->id);
        $sessionRow = DB::table('treatment_sessions')->find($session->id);

        $this->assertStringNotContainsString('Ernia', $patientRow->medical_history);
        $this->assertStringNotContainsString('RSSMRA', $patientRow->fiscal_code);
        $this->assertStringNotContainsString('Dolore', $sessionRow->assessment);
        $this->assertSame('Ernia L4-L5', $patient->fresh()->medical_history);
        $this->assertSame('Dolore irradiato', $session->fresh()->assessment);
    }

    #[Test]
    public function clinicalFieldsAreNotSerialized(): void
    {
        $patient = Patient::factory()->create(['medical_history' => 'Ernia L4-L5']);

        $this->assertStringNotContainsString('Ernia', $patient->toJson());
    }

    #[Test]
    public function websiteAdminsWithoutThePhysiotherapistRoleCannotSeeHealthData(): void
    {
        $patient = Patient::factory()->create();
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $this->assertFalse($admin->can('view', $patient));
        $this->assertFalse($admin->can('viewAny', Patient::class));
        $this->assertFalse($admin->can('viewAny', AccessLog::class));
        $this->assertFalse($admin->canAccessPanel(Filament::getPanel('gestionale')));

        $this->actingAs($admin)->get(PatientResource::getUrl('index'))->assertForbidden();
    }

    #[Test]
    public function guestsAreRedirectedToTheLogin(): void
    {
        $this->get(PatientResource::getUrl('index'))->assertRedirect('/gestionale/login');
    }

    #[Test]
    public function physiotherapistWithoutTwoFactorMustSetItUp(): void
    {
        $this->actingAs($this->physiotherapist())
            ->get(PatientResource::getUrl('index'))
            ->assertRedirect(Filament::getPanel('gestionale')->getSetUpRequiredMultiFactorAuthenticationUrl());
    }

    #[Test]
    public function openingAPatientIsLogged(): void
    {
        $user = $this->physiotherapist();
        $patient = Patient::factory()->create();
        $this->actingAs($user);

        Livewire::test(ViewPatient::class, ['record' => $patient->getRouteKey()])->assertOk();
        Livewire::test(EditPatient::class, ['record' => $patient->getRouteKey()])->assertOk();

        $this->assertSame(2, AccessLog::where([
            'event' => 'viewed',
            'user_id' => $user->id,
            'subject_type' => $patient->getMorphClass(),
            'subject_id' => $patient->id,
        ])->count());
    }

    #[Test]
    public function openingASessionIsLogged(): void
    {
        $user = $this->physiotherapist();
        $session = TreatmentSession::factory()->create();
        $this->actingAs($user);

        Livewire::test(ViewTreatmentSession::class, ['record' => $session->getRouteKey()])
            ->assertOk()
            ->assertSee('Limitazione in flessione');

        $this->assertDatabaseHas('access_logs', ['event' => 'viewed', 'subject_id' => $session->id, 'user_id' => $user->id]);
    }

    #[Test]
    public function changesAreLoggedWithFieldNamesButNotValues(): void
    {
        $user = $this->physiotherapist();
        $this->actingAs($user);

        $patient = Patient::factory()->create();
        $patient->update(['medications' => 'Ibuprofene']);
        $patient->delete();
        $patient->restore();

        $events = AccessLog::where('subject_id', $patient->id)->pluck('event')->all();
        $this->assertSame(['created', 'updated', 'deleted', 'restored'], $events);

        $updated = AccessLog::where('event', 'updated')->first();
        $this->assertSame(['medications'], $updated->properties['fields']);
        $this->assertStringNotContainsString('Ibuprofene', json_encode(AccessLog::all()->toArray()));
    }

    #[Test]
    public function accessLogsAreAppendOnly(): void
    {
        $log = AccessLog::record('login');

        $this->expectException(LogicException::class);
        $log->update(['event' => 'logout']);
    }

    #[Test]
    public function failedLoginsAreLogged(): void
    {
        auth()->attempt(['email' => 'nessuno@example.com', 'password' => 'sbagliata']);

        $this->assertDatabaseHas('access_logs', ['event' => 'login_failed']);
    }

    #[Test]
    public function backupRefusesToRunWithoutAnEncryptionPassword(): void
    {
        config(['backup.backup.password' => null]);

        $this->assertSame(1, Artisan::call('gestionale:backup'));
    }

    #[Test]
    public function grantAccessCommandAssignsTheRole(): void
    {
        $user = User::factory()->create();

        Artisan::call('gestionale:grant-access', ['email' => $user->email]);
        $this->assertTrue($user->fresh()->isPhysiotherapist());

        Artisan::call('gestionale:grant-access', ['email' => $user->email, '--revoke' => true]);
        $this->assertFalse($user->fresh()->isPhysiotherapist());
    }

    #[Test]
    public function listsAndFormsWork(): void
    {
        $this->actingAs($this->physiotherapist());
        $sessions = TreatmentSession::factory()->count(2)->create();
        $patient = $sessions->first()->patient;

        Livewire::test(ListPatients::class)->assertOk()->assertCanSeeTableRecords([$patient]);
        Livewire::test(ListTreatmentSessions::class)->assertOk()->assertCanSeeTableRecords($sessions);
        Livewire::test(ListAccessLogs::class)->assertOk();
        Livewire::test(TreatmentSessionsRelationManager::class, ['ownerRecord' => $patient, 'pageClass' => ViewPatient::class])
            ->assertOk()
            ->assertCanSeeTableRecords([$sessions->first()]);

        Livewire::test(CreatePatient::class)
            ->fillForm(['first_name' => 'Maria', 'last_name' => 'Rossi', 'allergies' => 'Lattice', 'fiscal_code' => 'rssmra80a41h501x'])
            ->call('create')
            ->assertHasNoFormErrors();
        $created = Patient::where('last_name', 'Rossi')->firstOrFail();
        $this->assertSame('Lattice', $created->allergies);
        $this->assertSame('RSSMRA80A41H501X', $created->fiscal_code);

        Livewire::withQueryParams(['patient' => $created->id])
            ->test(CreateTreatmentSession::class)
            ->assertSchemaStateSet(['patient_id' => $created->id])
            ->fillForm(['treatment' => 'Mobilizzazione', 'pain_before' => '7'])
            ->call('create')
            ->assertHasNoFormErrors();
        $this->assertSame('Mobilizzazione', $created->treatmentSessions()->firstOrFail()->treatment);
    }

    #[Test]
    public function filamentNameFallsBackToProfileAndEmail(): void
    {
        $user = User::factory()->create();
        $this->assertSame($user->email, $user->getFilamentName());

        UserProfile::factory()->create(['user_id' => $user->id, 'name' => 'Mario', 'surname' => 'Bianchi']);
        $this->assertSame('Mario Bianchi', $user->fresh()->getFilamentName());

        $user->assignRole(User::PHYSIOTHERAPIST_ROLE);
        $this->actingAs($user->fresh());
        Livewire::test(ListPatients::class)->assertOk();
    }

}
