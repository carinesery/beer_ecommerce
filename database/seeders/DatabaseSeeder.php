<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Product;




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
            'firstname' => 'Admin',
            'lastname' => 'Ladmin',
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => 'admin',
            'birthdate' => '1987-03-07',
        ]);

        Brand::factory(4)->create();

        Category::factory(4)->create();

        Product::factory(50)->create();

        ProductVariant::factory(200)->create();

    }
}
