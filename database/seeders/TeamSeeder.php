<?php

namespace Database\Seeders;

use Database\Factories\TeamFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TeamFactory::new()->count(10)->create();
    }
}
