<?php

namespace App\Http\Middleware;

use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarJwt
{
    /**
     * Verifica que la petición traiga un JWT válido en el header Authorization.
     * Formato esperado: Authorization: Bearer <token>
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header('Authorization');

        if (! $header || ! str_starts_with($header, 'Bearer ')) {
            return response()->json([
                'mensaje' => 'NO PUEDES PASAR',
            ], 401);
        }

        $token = substr($header, 7);

        $payload = JwtService::validar($token);

        if (! $payload) {
            return response()->json([
                'mensaje' => 'Ta como raro ese carné.',
            ], 401);
        }

        $request->attributes->set('usuario_jwt', $payload);

        return $next($request);
    }
}