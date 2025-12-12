<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkerSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('workers')->delete();
        DB::table('workers')->insert([
            [
                'id' => 1,
                'user_id' => User::role('admin','api')->first()->id, 
                'name' => 'John Doe',
                'phone' => '0123456789',
                'position' => 'Operator',
                'department' => 'Production',
                'image' => 'image.png', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
