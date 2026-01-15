<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // LOGIN -> grąžina Bearer token
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $user = User::where('el_pastas', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->slaptazodis)) {
            throw ValidationException::withMessages([
                'email' => ['Neteisingi prisijungimo duomenys.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    // CURRENT USER
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // LOGOUT -> ištrina tokenus
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Atsijungta']);
    }
}
