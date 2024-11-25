<?php 

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // Fetch the IDs of the categories and brands
        $sepatuCategoryId = DB::table('categories')->where('name', 'Sepatu')->value('id');
        $elektronikCategoryId = DB::table('categories')->where('name', 'Elektronik')->value('id');
        $adidasBrandId = DB::table('brands')->where('name', 'Adidas')->value('id');
        $sonyBrandId = DB::table('brands')->where('name', 'Sony')->value('id');

        // Insert products
        DB::table('products')->insert([
            [
                'name' => 'Adidas Sneakers',
                'price' => 100,
                'stock' => 50,
                'category_id' => $sepatuCategoryId,
                'brand_id' => $adidasBrandId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sony Headphones',
                'price' => 150,
                'stock' => 30,
                'category_id' => $elektronikCategoryId,
                'brand_id' => $sonyBrandId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Add more products as needed
        ]);
    }
}