<?php

namespace App\Http\Controllers\Api;

use App\Clients;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Para comparar senhas

class CustomerAuthController extends Controller
{
    /**
     * Login a user and return a token if successful.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function frontLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $client = Clients::where('email', $credentials['email'])->first();

        if ($client && $client->password === $credentials['password']) {
            $token = $client->createToken('authToken_client')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $client
            ], 200);
        }

        return response()->json(['error' => 'Email ou senha inválido!'], 401);
    }

    /**
     * Logout the user (invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function frontLogout(Request $request)
    {
        $user = $request->user();
        dd($user);
        $user->tokens()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso!'], 200);
    }
}
