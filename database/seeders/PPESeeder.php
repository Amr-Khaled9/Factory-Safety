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
            'ppe_type' => 'Veste and Helmet',
            'description' => 'Safety PPE type that includes both vest and helmet.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
