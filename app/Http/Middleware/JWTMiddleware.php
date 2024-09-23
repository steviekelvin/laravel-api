<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTMiddleware
{
    public function handle($request, Closure $next)
    {
        // Ignorar a validação JWT na rota de login
        if ($request->is('api') || $request->is('api/users/login') || $request->is('api/users/register')) {
            return $next($request);
        }
        try {
            // Verifica o token e autentica o usuário
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return $next($request);
    }
}
