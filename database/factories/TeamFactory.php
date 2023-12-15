<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'long_name' => fake()->words(2, true),
            'site_id' => SiteFactory::new()->create(),
            'league_id' => LeagueFactory::new()->create(),
            'ms_message' => fake()->word(),
        ];
    }
}
