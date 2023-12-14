<?php

namespace Database\Seeders;

use Database\Factories\LeagueFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeagueFactory::new()
            ->hasTeams()
            ->count(10)->create();
    }
}
