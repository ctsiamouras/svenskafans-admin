<?php

namespace Database\Seeders;

use Database\Factories\SportFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SportFactory::new()
            ->hasSites()
            ->count(10)->create();
    }
}
