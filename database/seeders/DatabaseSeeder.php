<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Product;
use Illuminate\Support\Str;




// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Marques
        $brands = [
            ['name' => 'Brasserie du Nord', 'logo' => 'brands/nord.jpg', 'description' => 'Brasserie artisanale du Nord de la France.'],
            ['name' => 'Les Mousses Sauvages', 'logo' => 'brands/mousses.jpg', 'description' => 'Spécialiste des bières houblonnées et sauvages.'],
            ['name' => 'Forge & Houblon', 'logo' => 'brands/forge.jpg', 'description' => 'Tradition brassicole alpine avec une touche moderne.'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        // Catégories
        $categories = [
            ['name' => 'Blonde', 'description' => 'Légère, florale, rafraîchissante.'],
            ['name' => 'Brune', 'description' => 'Corsée, torréfiée, profonde.'],
            ['name' => 'IPA', 'description' => 'Amère, houblonnée, aromatique.'],
            ['name' => 'Ambrée', 'description' => 'Caramel, douce, cuivrée.'],
            ['name' => 'Triple', 'description' => 'Forte, épicée, puissante.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Produits
        $products = [
            [
                'name' => 'La Blonde du Nord',
                'description' => 'Une blonde légère aux arômes floraux, parfaite pour l’été.',
                'alcohol_degree' => 5.0,
                'image' => 'products/blonde-nord.jpg',
                'category_id' => 1,
                'brand_id' => 1,
            ],
            [
                'name' => 'Brune de Forge',
                'description' => 'Une brune puissante aux notes de café et chocolat noir.',
                'alcohol_degree' => 6.2,
                'image' => 'products/brune-forge.jpg',
                'category_id' => 2,
                'brand_id' => 3,
            ],
            [
                'name' => 'IPA Sauvage',
                'description' => 'Une IPA fruitée et explosive, riche en houblons tropicaux.',
                'alcohol_degree' => 6.8,
                'image' => 'products/ipa-sauvage.jpg',
                'category_id' => 3,
                'brand_id' => 2,
            ],
            [
                'name' => 'Ambrée d’Automne',
                'description' => 'Ambrée douce avec des notes de caramel et de noisette.',
                'alcohol_degree' => 5.6,
                'image' => 'products/ambree-automne.jpg',
                'category_id' => 4,
                'brand_id' => 1,
            ],
            [
                'name' => 'Triple des Cimes',
                'description' => 'Une triple forte et épicée, au corps ample et chaleureux.',
                'alcohol_degree' => 8.3,
                'image' => 'products/triple-cimes.jpg',
                'category_id' => 5,
                'brand_id' => 3,
            ],
        ];

        foreach ($products as $index => $productData) {
            $product = Product::create([
                ...$productData,
                'slug' => Str::slug($productData['name']),
            ]);

            // Variantes 33cl et 75cl
            ProductVariant::insert([
                [
                    'product_id' => $product->id,
                    'slug' => Str::slug($productData['name'] . '-33cl'),
                    'volume' => '33cl',
                    'stock_quantity' => 100,
                    'price_without_tax' => rand(250, 350), // entre 2.50€ et 3.50€
                    'tax_amount' => 0.2 * rand(250, 350),
                    'available' => true,
                ],
                [
                    'product_id' => $product->id,
                    'slug' => Str::slug($productData['name'] . '-75cl'),
                    'volume' => '75cl',
                    'stock_quantity' => 50,
                    'price_without_tax' => rand(450, 600), // entre 4.50€ et 6.00€
                    'tax_amount' => 0.2 * rand(450, 600),
                    'available' => true,
                ],
            ]);
        }

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

    }
}
        
        // Brand::factory(4)->create();

        // Category::factory(4)->create();

        // Product::factory(50)->create();

        // ProductVariant::factory(200)->create();
