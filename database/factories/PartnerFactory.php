<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            Partner::NAME => fake()->company(),
            Partner::IMAGE => null,
            Partner::LINK => fake()->url(),
        ];
    }
}
