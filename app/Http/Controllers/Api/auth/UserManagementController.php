<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function CreateUser(CreateUserRequest $request)
    {
        if (!$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'You are not allowed to perform this action'], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->name),
            'email_verified_at' => now(),
        ]);
        if ($request->role == 'admin') {
            $adminRole = Role::findByName('admin', 'api');

            $user->assignRole($adminRole);
        } else {
            $userRole = Role::findByName('user', 'api');

            $user->assignRole($userRole);
        }
        return response()->json([
            'status'  => 'success',
            'message' => 'Login successful',
            'data'    => [
                'user'  => $user,
            ],
        ]);
    }
}
