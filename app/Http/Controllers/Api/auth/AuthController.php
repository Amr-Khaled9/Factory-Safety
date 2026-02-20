<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        // 1. Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Create User
        $user = User::create([
            'name'   => $request->name,
            'email'  => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');

        // 3. Create Token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user'  => UserResource::make($user),
                'token' => $token,
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'        => 'required|email',
            'password'     => 'required|string',
            'fcm_token'    => 'required|string',
            'platform'     => 'required|in:android,ios',
            'device_name'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid email or password',
            ], 401);
        }

        $user = Auth::user();

        if ($request->filled(['fcm_token', 'platform'])) {
            $user->addFcmToken(
                $request->fcm_token,
                $request->platform,
                $request->device_name
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;
 
        return response()->json([
            'status'  => 'success',
            'message' => 'Login successful',
            'data'    => [
                'user'  => $user,
                'token' => $token,
            ],
        ]);
    }


    // Profile
    public function profile(Request $request)
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'User profile retrieved successfully',
            'data'    => [
                'user' => $request->user(),
            ],
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Logged out successfully',
        ]);
    }

    // Forgot Password
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => Hash::make($token),
                'created_at' => now(),
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Password reset token generated successfully.',
            'reset_token' => $token
        ], 200);
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'token'    => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $reset = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$reset) {
            return response()->json(['status' => 'error', 'message' => 'Token not found'], 400);
        }

        if (!Hash::check($request->token, $reset->token)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid token'], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Password has been reset successfully.'
        ], 200);
    }
}
