<?php

namespace App\Http\Middleware;

use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarJwtWeb
{
    /**
     * Igual que VerificarJwt, pero pensado para vistas Blade: en vez de
     * leer el header Authorization, revisa el JWT guardado en sesión y,
     * si no es válido, redirige al login en lugar de responder JSON.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->session()->get('jwt');

        $payload = $token ? JwtService::validar($token) : null;

        if (! $payload) {
            $request->session()->forget('jwt');

            return redirect('/login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        $request->attributes->set('usuario_jwt', $payload);

        return $next($request);
    }
}