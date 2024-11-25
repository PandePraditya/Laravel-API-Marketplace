<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'V9HkF@example.com',
            'password' => bcrypt('admin123'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
