<?php

namespace Database\Factories;

use App\Enums\VatCode;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'code' => strtoupper($this->faker->unique()->bothify('SRV-##')),
            'color' => $this->faker->randomElement(Service::COLORS),
            'duration_minutes' => 30,
            'vat_code' => VatCode::N4,
            'price' => '50.00',
        ];
    }
}
