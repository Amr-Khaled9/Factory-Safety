<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // حذف الكاش
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        DB::table('model_has_roles')->delete();
        DB::table('roles')->delete();
        DB::table('permissions')->delete();

        $permissions = ['view-post', 'create-post', 'edit-post', 'delete-post', 'all'];
        foreach ($permissions as $perm) {
            Permission::create([
                'name' => $perm,
                'guard_name' => 'api'
            ]);
        }
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'api']);
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'api']);

        $userRole->givePermissionTo('view-post',);
        $adminRole->givePermissionTo(Permission::all());

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'email_verified_at' => now()
        ]);
        $adminRole = Role::findByName('admin', 'api');
        $admin->assignRole($adminRole);
    }
}
