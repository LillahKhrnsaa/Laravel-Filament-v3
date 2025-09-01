<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\API\TokenApiController;
use Symfony\Component\HttpFoundation\Response;

class CheckApiToken
{
    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $this->extractToken($request);
        
        if (!$token || !TokenApiController::verifyToken($token)) {
            return response()->json([
                'error' => 'Invalid token',
                'hint' => 'Use token from /api/get-token endpoint',
                'received_token' => $token ? '****'.substr($token, -4) : 'none', // Mask actual token
                'expected_token_length' => strlen(TokenApiController::getStaticToken())
            ], 401);
        }

        return $next($request);
    }

    /**
     * Extract token from request
     */
    protected function extractToken(Request $request)
    {
        // Check query parameter first
        if ($request->query('token')) {
            return $request->query('token');
        }

        // Check Authorization header
        $header = $request->header('Authorization');
        
        if (empty($header)) {
            return null;
        }

        // Extract from Bearer token
        if (str_starts_with($header, 'Bearer ')) {
            return substr($header, 7);
        }

        return $header;
    }
}