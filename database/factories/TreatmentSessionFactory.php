<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\TreatmentSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class TreatmentSessionFactory extends Factory
{
    protected $model = TreatmentSession::class;

    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'performed_at' => $this->faker->dateTimeBetween('-1 year'),
            'duration_minutes' => 60,
            'pain_before' => '6',
            'pain_after' => '3',
            'assessment' => 'Limitazione in flessione del rachide lombare',
            'treatment' => 'Terapia manuale e mobilizzazioni',
        ];
    }
}
