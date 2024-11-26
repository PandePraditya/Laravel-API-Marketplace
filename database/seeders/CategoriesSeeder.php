<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('categories')->insert([
            [
                'name' => 'Sepatu',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Elektronik',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
