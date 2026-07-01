<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private function adminEmail(): string
    {
        return env('PORTFOLIO_ADMIN_EMAIL', 'admin@portfolio.com');
    }

    private function adminPassword(): string
    {
        return env('PORTFOLIO_ADMIN_PASSWORD', 'admin123');
    }

    private function adminToken(): string
    {
        return hash_hmac('sha256', $this->adminEmail(), config('app.key'));
    }

    /**
     * POST /api/auth/login
     * Body: { "email": "...", "password": "..." }
     * Returns: { "token": "..." }
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if ($request->password !== $this->adminPassword()) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 422);
        }

        return response()->json([
            'token' => $this->adminToken(),
        ]);
    }

    /**
     * POST /api/auth/logout
     * Stateless token flow: the client just discards its token.
     */
    public function logout(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Logged out.']);
    }
}