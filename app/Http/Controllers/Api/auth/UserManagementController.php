<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
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
            'message' => 'User created successfully',
            'data'    => [
                'user'  => $user,
            ],
        ], 201);
    }

    
    public function index(Request $request)
    {
        if (!$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'You are not allowed to perform this action'], 403);
        }

        $users = User::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved successfully',
            'data' => $users
        ]);
    }

    
    public function show(Request $request, User $user)
    {
        if (!$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'You are not allowed to perform this action'], 403);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User retrieved successfully',
            'data' => $user
        ]);
    }

    
    public function update(Request $request, User $user)
    {
        if (!$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'You are not allowed to perform this action'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'sometimes|string|in:admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        
        if ($request->role) {
            $user->syncRoles([$request->role]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    
    public function destroy(Request $request, User $user)
    {
        if (!$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'You are not allowed to perform this action'], 403);
        }

        
        if ($request->user()->id === $user->id) {
            return response()->json(['message' => 'Cannot delete yourself'], 403);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully',
        ]);
    }
}
