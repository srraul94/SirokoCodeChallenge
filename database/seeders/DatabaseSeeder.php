<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Domain\Product\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Air Jordan Travis Scott',
            'Price' => 1599.99
        ]);

        Product::create([
            'name' => 'Air Force 1 Utopia Travis Scott',
            'Price' => 199.99
        ]);

        Product::create([
            'name' => 'Air Jordan Blue Travis Scott',
            'Price' => 1000.99
        ]);

        Product::create([
            'name' => 'Jordan Purple Travis Scott',
            'Price' => 259.45
        ]);

        Product::create([
            'name' => 'Jordan Blue Travis Scott',
            'Price' => 259.45
        ]);

        Product::create([
            'name' => 'Air Jordan Blue Cactus Jack',
            'Price' => 1259.45
        ]);

        Product::create([
            'name' => 'Nike Dunk Gray',
            'Price' => 99.45
        ]);

        Product::create([
            'name' => 'Air Jordan Cactus Jack Exclusive',
            'Price' => 2999.99
        ]);
    }
}
