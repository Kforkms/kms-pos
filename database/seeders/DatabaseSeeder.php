<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Ingredient;
use App\Models\Package;
use App\Models\Shift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =============================================
        // 1. USERS
        // =============================================
        $admin = User::create([
            'name' => 'Admin POS',
            'email' => 'admin@pos.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $kasir = User::create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@pos.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        // =============================================
        // 2. INGREDIENTS (Bahan Baku)
        // =============================================
        $ingredients = [
            ['name' => 'Beras',           'stock' => 50000, 'unit' => 'gram'],
            ['name' => 'Mie Instant',     'stock' => 200,   'unit' => 'pcs'],
            ['name' => 'Ayam Potong',     'stock' => 10000, 'unit' => 'gram'],
            ['name' => 'Telur',           'stock' => 300,   'unit' => 'pcs'],
            ['name' => 'Kopi Bubuk',      'stock' => 5000,  'unit' => 'gram'],
            ['name' => 'Susu Cair',       'stock' => 10000, 'unit' => 'ml'],
            ['name' => 'Gula Aren',       'stock' => 3000,  'unit' => 'gram'],
            ['name' => 'Gula Pasir',      'stock' => 5000,  'unit' => 'gram'],
            ['name' => 'Es Batu',         'stock' => 500,   'unit' => 'pcs'],
            ['name' => 'Teh Celup',       'stock' => 200,   'unit' => 'pcs'],
            ['name' => 'Minyak Goreng',   'stock' => 10000, 'unit' => 'ml'],
            ['name' => 'Bawang Putih',    'stock' => 2000,  'unit' => 'gram'],
            ['name' => 'Kecap Manis',     'stock' => 3000,  'unit' => 'ml'],
            ['name' => 'Sambal',          'stock' => 2000,  'unit' => 'gram'],
            ['name' => 'Seafood Mix',     'stock' => 5000,  'unit' => 'gram'],
            ['name' => 'Kerupuk',         'stock' => 500,   'unit' => 'pcs'],
            ['name' => 'Coklat Bubuk',    'stock' => 2000,  'unit' => 'gram'],
            ['name' => 'Roti Tawar',      'stock' => 100,   'unit' => 'pcs'],
            ['name' => 'Keju Slice',      'stock' => 100,   'unit' => 'pcs'],
            ['name' => 'Kentang',         'stock' => 5000,  'unit' => 'gram'],
        ];

        $ingredientModels = [];
        foreach ($ingredients as $ing) {
            $ingredientModels[$ing['name']] = Ingredient::create($ing);
        }

        // =============================================
        // 3. PRODUCTS (with category & image_url)
        // =============================================
        $products = [
            // MAKANAN
            [
                'name' => 'Nasi Goreng Spesial',
                'price' => 25000,
                'stock' => 50,
                'category' => 'makanan',
                'image_url' => null,
                'recipe' => [
                    'Beras' => 200,
                    'Telur' => 1,
                    'Bawang Putih' => 10,
                    'Kecap Manis' => 15,
                    'Minyak Goreng' => 30,
                    'Kerupuk' => 2,
                ],
            ],
            [
                'name' => 'Mie Goreng Seafood',
                'price' => 30000,
                'stock' => 40,
                'category' => 'makanan',
                'image_url' => null,
                'recipe' => [
                    'Mie Instant' => 2,
                    'Seafood Mix' => 100,
                    'Bawang Putih' => 10,
                    'Kecap Manis' => 15,
                    'Minyak Goreng' => 30,
                    'Telur' => 1,
                ],
            ],
            [
                'name' => 'Ayam Penyet + Nasi',
                'price' => 22000,
                'stock' => 30,
                'category' => 'makanan',
                'image_url' => null,
                'recipe' => [
                    'Beras' => 200,
                    'Ayam Potong' => 200,
                    'Sambal' => 30,
                    'Minyak Goreng' => 50,
                    'Kerupuk' => 2,
                ],
            ],
            [
                'name' => 'Nasi + Telur Dadar',
                'price' => 15000,
                'stock' => 50,
                'category' => 'makanan',
                'image_url' => null,
                'recipe' => [
                    'Beras' => 200,
                    'Telur' => 2,
                    'Minyak Goreng' => 20,
                    'Bawang Putih' => 5,
                ],
            ],
            [
                'name' => 'Kentang Goreng',
                'price' => 18000,
                'stock' => 40,
                'category' => 'makanan',
                'image_url' => null,
                'recipe' => [
                    'Kentang' => 200,
                    'Minyak Goreng' => 100,
                ],
            ],
            [
                'name' => 'Roti Bakar Keju',
                'price' => 15000,
                'stock' => 35,
                'category' => 'makanan',
                'image_url' => null,
                'recipe' => [
                    'Roti Tawar' => 2,
                    'Keju Slice' => 2,
                ],
            ],

            // MINUMAN
            [
                'name' => 'Es Teh Manis',
                'price' => 5000,
                'stock' => 100,
                'category' => 'minuman',
                'image_url' => null,
                'recipe' => [
                    'Teh Celup' => 1,
                    'Gula Pasir' => 20,
                    'Es Batu' => 3,
                ],
            ],
            [
                'name' => 'Kopi Susu Gula Aren',
                'price' => 18000,
                'stock' => 60,
                'category' => 'minuman',
                'image_url' => null,
                'recipe' => [
                    'Kopi Bubuk' => 15,
                    'Susu Cair' => 150,
                    'Gula Aren' => 20,
                    'Es Batu' => 3,
                ],
            ],
            [
                'name' => 'Coklat Susu Dingin',
                'price' => 16000,
                'stock' => 50,
                'category' => 'minuman',
                'image_url' => null,
                'recipe' => [
                    'Coklat Bubuk' => 25,
                    'Susu Cair' => 200,
                    'Gula Pasir' => 15,
                    'Es Batu' => 3,
                ],
            ],
            [
                'name' => 'Es Kopi Hitam',
                'price' => 12000,
                'stock' => 70,
                'category' => 'minuman',
                'image_url' => null,
                'recipe' => [
                    'Kopi Bubuk' => 20,
                    'Gula Pasir' => 15,
                    'Es Batu' => 4,
                ],
            ],

            // SNACK
            [
                'name' => 'Kerupuk Udang',
                'price' => 8000,
                'stock' => 80,
                'category' => 'snack',
                'image_url' => null,
                'recipe' => [],
            ],
            [
                'name' => 'Pisang Goreng (5 pcs)',
                'price' => 12000,
                'stock' => 30,
                'category' => 'snack',
                'image_url' => null,
                'recipe' => [
                    'Minyak Goreng' => 50,
                    'Gula Pasir' => 10,
                ],
            ],
            [
                'name' => 'Tahu Crispy (6 pcs)',
                'price' => 10000,
                'stock' => 40,
                'category' => 'snack',
                'image_url' => null,
                'recipe' => [
                    'Minyak Goreng' => 50,
                ],
            ],
        ];

        $productModels = [];
        foreach ($products as $p) {
            $recipe = $p['recipe'] ?? [];
            unset($p['recipe']);

            $product = Product::create([
                'name' => $p['name'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'category' => $p['category'],
                'image_url' => $p['image_url'],
            ]);

            $productModels[$p['name']] = $product;

            // Attach ingredient recipe
            foreach ($recipe as $ingredientName => $qtyRequired) {
                if (isset($ingredientModels[$ingredientName])) {
                    $product->ingredients()->attach($ingredientModels[$ingredientName]->id, [
                        'qty_required' => $qtyRequired,
                    ]);
                }
            }
        }

        // =============================================
        // 4. PACKAGES (Menu Paket / Combo)
        // =============================================
        $paketA = Package::create([
            'name' => 'Paket Hemat A',
            'price' => 35000,
            'description' => 'Nasi Goreng Spesial + Es Teh Manis + Kerupuk Udang',
        ]);
        $paketA->products()->attach([
            $productModels['Nasi Goreng Spesial']->id => ['qty' => 1],
            $productModels['Es Teh Manis']->id => ['qty' => 1],
            $productModels['Kerupuk Udang']->id => ['qty' => 1],
        ]);

        $paketB = Package::create([
            'name' => 'Paket Hemat B',
            'price' => 45000,
            'description' => 'Ayam Penyet + Nasi + Kopi Susu Gula Aren',
        ]);
        $paketB->products()->attach([
            $productModels['Ayam Penyet + Nasi']->id => ['qty' => 1],
            $productModels['Kopi Susu Gula Aren']->id => ['qty' => 1],
        ]);

        $paketC = Package::create([
            'name' => 'Paket Mie Seafood Combo',
            'price' => 40000,
            'description' => 'Mie Goreng Seafood + Coklat Susu Dingin',
        ]);
        $paketC->products()->attach([
            $productModels['Mie Goreng Seafood']->id => ['qty' => 1],
            $productModels['Coklat Susu Dingin']->id => ['qty' => 1],
        ]);

        // =============================================
        // 5. OPEN SHIFT for admin
        // =============================================
        Shift::create([
            'user_id' => $admin->id,
            'starting_cash' => 500000,
            'status' => 'open',
            'opened_at' => Carbon::now(),
        ]);

        // =============================================
        // 6. SETTINGS
        // =============================================
        Setting::create([
            'key' => 'qris_image_path',
            'value' => 'qris_static.png',
        ]);
    }
}
