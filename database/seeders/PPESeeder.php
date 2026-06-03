<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PPESeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ppes')->delete();

        DB::table('ppes')->insert([
            [
                'ppe_type' => 'helmet',
                'description' => 'Safety helmet for head protection.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ppe_type' => 'vest',
                'description' => 'High-visibility safety vest.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ppe_type' => 'gloves',
                'description' => 'Protective safety gloves.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ppe_type' => 'glasses',
                'description' => 'Protective safety glasses.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ppe_type' => 'mask',
                'description' => 'Protective face mask.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ppe_type' => 'boots',
                'description' => 'Protective safety boots.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
