<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    // Admin Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 401);
        }
    
        if ($user->role_as !== 1) {
            return response()->json(['message' => 'User is not an admin'], 403);
        }
    
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Incorrect password'], 401);
        }
    
        $token = $user->createToken('AdminToken', ['server:admin'])->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ], 200);
    }
    
}
