<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create(
            [
            'role' => 'customer',
        ]);

        User::factory()->create([
            'firstname' => 'AdminUser',
            'lastname' => 'LastUser',
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => 'admin',
            'birthdate' => '1987-03-07',
        ]);
    }
}
