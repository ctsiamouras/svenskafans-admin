<?php

namespace Database\Seeders;

use Database\Factories\CountryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CountryFactory::new()
            ->hasSites()
            ->count(10)->create();
    }
}
