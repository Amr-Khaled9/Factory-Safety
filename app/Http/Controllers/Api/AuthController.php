<?php

namespace App\Http\Controllers\Api;


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
    // دالة التسجيل (Register)
    public function register(Request $request)
    {
        // 1. Validation (التأكد من صحة البيانات)
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
            ], 422); // 422: Unprocessable Entity
        }

        // 2. إنشاء المستخدم (Create User)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. إنشاء الـ Token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
    'status' => 'success',
    'message' => 'User registered successfully',
    'data' => [
        'user' => UserResource::make($user),
        'token' => $token,
    ]
], 201);
    }

    // دالة تسجيل الدخول (Login)
    public function login(Request $request)
    {
        // 1. Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. محاولة تسجيل الدخول
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid login details',
            ], 401); 
        }

    
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    }

    
    public function profile(Request $request)
    {
        
        return response()->json([
            'status' => 'success',
            'message' => 'User profile retrieved successfully',
            'data' => [
                'user' => $request->user(),
            ]
        ]);
    }

    
    public function logout(Request $request)
    {
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ]);
    }


    
   public function forgotPassword(Request $request)
    {
        // 1. Validation: نتأكد إن الإيميل موجود
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'تم إنشاء رمز إعادة تعيين كلمة المرور.',
            'reset_token' => $token
        ], 200);
    }
public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $reset = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$reset) {
            return response()->json(['status' => 'error', 'message' => 'Token غير موجود'], 400);
        }

        if (!Hash::check($request->token, $reset->token)) {
            return response()->json(['status' => 'error', 'message' => 'Token غير صحيح'], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // حذف الـ token بعد التغيير
        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تغيير كلمة المرور بنجاح.'
        ], 200);
    }

   
    }


    

    // دالة إعادة تعيين كلمة السر (Reset Password)
    
