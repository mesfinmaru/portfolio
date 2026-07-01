<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePortfolioAdminToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expectedToken = hash_hmac('sha256', env('PORTFOLIO_ADMIN_EMAIL', 'admin@portfolio.com'), config('app.key'));
        $providedToken = $request->bearerToken();

        if (! $providedToken || ! hash_equals($expectedToken, $providedToken)) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        return $next($request);
    }
}