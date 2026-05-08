<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class DummyJwtMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Mencoba membaca token dari header dan mengambil payload-nya [cite: 539]
            $payload = JWTAuth::parseToken()->getPayload();
            // Menyisipkan payload ke dalam request agar bisa diakses di Controller [cite: 540]
            $request->merge(['jwt_payload' => $payload]);
        } catch (JWTException $e) {
            // Jika token tidak ada, tidak valid, atau kadaluarsa [cite: 541-545]
            return response()->json([
                'message' => 'Token invalid or expired',
                'error' => $e->getMessage()
            ], 401);
        }

        return $next($request);
    }

    
}