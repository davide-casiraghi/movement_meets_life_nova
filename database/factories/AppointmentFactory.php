<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Enums\AppointmentType;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $start = now()->addDay()->setTime(10, 0);

        return [
            'type' => AppointmentType::Work,
            'status' => AppointmentStatus::Scheduled,
            'title' => 'Terapia manuale',
            'starts_at' => $start,
            'ends_at' => $start->copy()->addMinutes(30),
        ];
    }
}
