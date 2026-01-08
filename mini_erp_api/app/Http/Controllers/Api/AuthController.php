<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return apiError('Hatalı giriş bilgileri', 401);
        }

        /** @var User $user */
        $user = Auth::user();

        $token = $user->createToken('api-token')->plainTextToken;

        $user->load(['role', 'departments']);

        return apiSuccess([
            'token' => $token,
            'user' => $user,
        ], 'Giriş başarılı');
    }

    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $user->currentAccessToken()?->delete();

        return apiSuccess(null, 'Çıkış yapıldı');
    }

    public function me(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $user->load(['role', 'departments']);

        return apiSuccess($user);
    }
}
