<?php

namespace Database\Seeders;

use Database\Factories\SiteFactory;
use Database\Factories\TeamFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteFactory::new()
            ->hasTeams()
            ->hasLeagues()
            ->count(10)->create();
    }
}
