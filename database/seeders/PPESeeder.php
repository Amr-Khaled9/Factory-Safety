<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PPESeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ppes')->delete();

        DB::table('ppes')->insert([
            'ppe_type' => 'veste',
            'description' => 'A safety vest that enhances visibility and protects the upper body.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ppes')->insert([
            'ppe_type' => 'helmet',
            'description' => 'A safety helmet designed to protect the head from impacts and falling objects.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
