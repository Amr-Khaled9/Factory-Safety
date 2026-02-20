<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(1)->create();
        $adminRole = Role::findByName('admin', 'api');
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
        ])->assignRole($adminRole);


        $this->call([
            RolePermissionSeeder::class,
            PPESeeder::class,
            CameraSeeder::class,    
            WorkerSeeder::class,
        ]);
    }
}
