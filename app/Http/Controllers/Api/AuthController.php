<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Generator\StringManipulation\Pass\RemoveUnserializeForInternalSerializableClassesPass;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "min:3"],
            "email" => ['required', "email", "unique:users,email"],
            "password" => ["required", "string", "min:6", "confirmed"]
        ]);

        $user = User::create([
            "name" => $validated['name'],
            "email" => $validated['email'],
            "role" => "member",
            "password" => Hash::make($validated['password'])
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            "token" => $token,
            "user" => $user
        ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        $user = User::where("email", $validated['email'])->first();
        if (empty($user)) {
            return response()->json([
                "message" => "user not found!"
            ], 404);
        }
        if (Auth::attempt($validated)) {
            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                "token" => $token,
                "user" => $user
            ]);
        }

        return response()->json([
            "message" => "invalid credentials!"
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            "message" => "Logged out"
        ]);
    }
}
