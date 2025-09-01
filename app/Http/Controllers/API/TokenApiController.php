<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TokenApiController extends Controller
{
    // Hardcoded token for testing
    protected static $STATIC_TOKEN = 'UW5jklAFKPv5B1jyLWRmq10wDPjBIofIGItLeIVFYfsxyGlWATswHfQFfT3qEhIRmDWUZJ9qzsA4EdMRM1D9SV6ecmC3FKzzv0I4';

    /**
     * Generate and return the static token
     */
    public function generateToken()
    {
        return response()->json([
            'token' => self::getStaticToken(),
            'message' => 'Token generated successfully'
        ]);
    }

    /**
     * Verify if the provided token matches our static token
     */
    public static function verifyToken($token)
    {
        return hash_equals(self::getStaticToken(), $token);
    }

    /**
     * Getter for static token
     */
    public static function getStaticToken()
    {
        return self::$STATIC_TOKEN;
    }
}