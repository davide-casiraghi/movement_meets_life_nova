<?php

namespace App\Providers;

use App\Contracts\ContainsHealthData;
use App\Models\AccessLog;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\TreatmentSession;
use App\Models\User;
use App\Policies\AccessLogPolicy;
use App\Policies\AppointmentPolicy;
use App\Policies\PatientPolicy;
use App\Policies\TreatmentSessionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Patient::class => PatientPolicy::class,
        Appointment::class => AppointmentPolicy::class,
        TreatmentSession::class => TreatmentSessionPolicy::class,
        AccessLog::class => AccessLogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        // Give the admin full authorization to this resource
        // Health data and its audit trail are excluded: their policies always decide.
        Gate::before(function (User $user, string $ability, array $arguments) {
            if (self::concernsHealthData($arguments)) {
                return null;
            }

            if ($user->isAdmin()) {
                return true;
            }
        });
    }

    /**
     * True when the gate check is about a model holding health data or about the access log.
     */
    private static function concernsHealthData(array $arguments): bool
    {
        $subject = $arguments[0] ?? null;

        if (is_object($subject)) {
            $subject = $subject::class;
        }

        return is_string($subject)
            && (is_a($subject, ContainsHealthData::class, true) || is_a($subject, AccessLog::class, true));
    }
}
