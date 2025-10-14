<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:155',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth_token', ['post:read', 'post:create'])->plainTextToken;

        return response()->json(['ok' => true, 'user' => $user, 'token' => $token]);
    }

    function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($validated)) {
            $user = User::where('email', $validated['email'])->first();

            $token = $user->createToken('auth_token', ['post:read', 'post:create'])->plainTextToken;

            return response()->json(['ok' => true, 'token' => $token], 200);
        }

        return response()->json(['ok' => false, 'message' => 'Credenciais inválidas'], 401);
    }

    function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['ok' => false, 'message' => 'Token não informado'], 400);
        }

        $access_token = PersonalAccessToken::findToken($token);

        if (!$access_token) {
            return response()->json(['ok' => false, 'message' => 'Token inválido'], 400);
        }

        $access_token->delete();

        return response()->json(['ok' => true, 'message' => 'Logout realizado com sucesso'], 200);
    }
}
