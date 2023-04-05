<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validastion
        $attr = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        //creating user
        $user = User::create([
            'name' => $attr['name'],
            'email' => $attr['email'],
            'password' => $attr['password'],
        ]);

        // return response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken,
        ], 200);
    }

    public function login(Request $request)
    {
        // validastion
        $attr = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (!Auth::attempt($attr)) {
            return response([
                'message' => 'Invalid Credianstionals',
            ], 403);
        }

        // return response
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken,
        ], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logout Success',
        ], 200);
    }

    public function user()
    {
        return response([
            'user' => auth()->user(),
        ], 200);
    }
}
