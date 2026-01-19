<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Authentication Endpoints"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login and get Bearer token",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|abc123xyz"),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Invalid credentials")
     * )
     */
    // LOGIN -> grąžina Bearer token
    public function login(Request $request)
{
    $request->validate([
        'email' => ['required','email'],
        'password' => ['required'],
    ]);

   $user = User::where('el_pastas', $request->email)->first();

if (! $user || ! Hash::check($request->password, $user->slaptazodis)) {
    return response()->json([
        'message' => 'Neteisingi prisijungimo duomenys.'
    ], 422);
}

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
}
    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get current authenticated user",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Authenticated user data"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    // CURRENT USER
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout user (revoke tokens)",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Logged out successfully"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    // LOGOUT -> ištrina tokenus
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Atsijungta']);
    }
}
