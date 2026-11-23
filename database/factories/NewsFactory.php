<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            News::TITLE => fake()->sentence(),
            News::DESCRIPTION => fake()->paragraph(),
            News::AUTHOR_ID => User::factory(),
            News::IMAGES => null,
        ];
    }

    /**
     * Set the image paths, encoded the same way the admin stores them.
     *
     * @param  list<string>  $paths
     */
    public function withImages(array $paths): static
    {
        return $this->state([News::IMAGES => json_encode($paths)]);
    }
}
