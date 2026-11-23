<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Testimonials are pending by default, like the ones sent by the public.
 *
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            Testimonial::NAME => fake()->name(),
            Testimonial::DESCRIPTION => fake()->text(200),
            Testimonial::IMAGE => null,
            Testimonial::IS_APPROVED => false,
        ];
    }

    public function approved(): static
    {
        return $this->state([Testimonial::IS_APPROVED => true]);
    }
}
