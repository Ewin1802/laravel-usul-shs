<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email'=> 'email|required|unique:users',
            'password'=> 'required',
            'phone'=> 'required',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone' => $validatedData['phone'],
            'skpd' => 'NoSKPD',
            'roles' => 'USER', // Set default role to USER

        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => UserResource::make($user),
        ]);
    }


    public function login (Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        $user = User::where('email', $loginData['email'])->first();

        if(!$user) {
            return response()->json(['message' => 'User Not Found'], 401);
        }

        if(!Hash::check($loginData['password'], $user->password)) {
            return  response()->json(['message' => 'Invalid Credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;


        return  response()->json([
            'access_token' => $token,
            'user' => UserResource::make($user),
        ]);
    }

    public function logout (Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return  response()->json([
            'message' => 'Logout Success',
        ]);
    }
}
