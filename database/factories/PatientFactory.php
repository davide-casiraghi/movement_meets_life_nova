<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'fiscal_code' => strtoupper($this->faker->bothify('??????##?##?###?')),
            'current_complaint' => 'Lombalgia da tre settimane',
            'medical_history' => 'Appendicectomia nel 2010',
        ];
    }
}
