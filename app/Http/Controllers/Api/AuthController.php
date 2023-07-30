<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Register successfully'
        ], 201);
    }

    public function login(Request $request){
        if(!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $user = Auth::user();
            return response()->json([
              'status' => false,
              'message' => 'Invalid Credentials',
            ], 400);
        };

        $token = Auth::user()->createToken('authToken')->accessToken;
        return response()->json([
                  'status' => true,
                  'message' => 'Login successfully',
                  'user' => Auth::user(),
                  'token' => $token
                ], 200);
    }

    public function profile(){
        return response()->json([
            'status' => true,
            'message' => 'Profile information retrieved successfully.',
            'user' => Auth::user()
        ]);
    }

    public function logout(Request $request){
        $token = $request->user()->token();
        $token->revoke();
        return response()->json([
          'status' => true,
          'message' => 'Logout successfully'
        ], 200);

    }
}
