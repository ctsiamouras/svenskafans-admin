<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\TeamFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->create([
            'email' => 'admin@example.com',
            'username' => 'admin',
            'user_role_id' => 1,
        ]);
        UserFactory::new()->count(10)->create()->each(function (User $user) {
            $user->teams()->attach(TeamFactory::new()->create());
        });
    }
}
