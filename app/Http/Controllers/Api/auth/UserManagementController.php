<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{

    public function CreateUser(CreateUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->name),
            'email_verified_at' => now(),

        ]);

        if ($request->filled(['fcm_token', 'platform'])) {
            $user->addFcmToken(
                $request->fcm_token,
                $request->platform,
                $request->device_name
            );
        }

        $userRole = Role::findByName('user', 'api');

        $user->assignRole($userRole);
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
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved successfully',
            'data' => $users
        ]);
    }


    public function show(Request $request, User $user)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User retrieved successfully',
            'data' => $user
        ]);
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
         if (isset($validated['name'])) {
            $user->name = $validated['name'];
        }

        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if (isset($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }



    public function destroy(Request $request, User $user)
    {
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
