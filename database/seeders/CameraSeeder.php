<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CameraSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('cameras')->delete();
        DB::table('cameras')->insert([
            [
                'id' => 1,
                'number_camera' => 1,
                'user_id' => User::role('admin','api')->first()->id,
                'location' => 'Main Entrance',
                'status' => 'Active',
                'installation_date' => '2025-12-12',
                'department' => 'Security',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
