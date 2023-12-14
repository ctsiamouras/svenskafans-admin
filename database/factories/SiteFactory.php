<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Site>
 */
class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->country(),
            'url' => '/' . fake()->unique()->slug(2, false),
            'sort_order' => fake()->randomNumber(),
            'sport_id' => SportFactory::new()->create(),
            'country_id' => CountryFactory::new()->create(),
        ];
    }
}