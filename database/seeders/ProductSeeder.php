<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'T-Shirt',
            'price' => 14.99,
            'stock_quantity' => 10
        ]);

        Product::create([
            'name' => 'Jacket',
            'price' => 24.99,
            'stock_quantity' => 50
        ]);

        Product::create([
            'name' => 'Blouse',
            'price' => 19.99,
            'stock_quantity' => 3
        ]);

        Product::create([
            'name' => 'Coat',
            'price' => 34.99,
            'stock_quantity' => 20
        ]);
    }
}
