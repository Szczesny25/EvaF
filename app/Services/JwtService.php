<?php

namespace App\Services;

class JwtService
{
    /**
     * Clave secreta usada para firmar el token.
     * Se apoya en la APP_KEY que Laravel ya genera por defecto.
     */
    protected static function claveSecreta(): string
    {
        return config('app.key');
    }

    /**
     * Codifica un string en base64 "url safe" (sin +, / ni =),
     * que es el formato que usa el estándar JWT.
     */
    protected static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    protected static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    /**
     * Genera un JWT firmado a partir de un arreglo de datos (payload).
     * Un JWT tiene 3 partes separadas por punto: header.payload.firma
     */
    public static function generar(array $payload, int $minutosExpiracion = 60): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        $payload['iat'] = time();
        $payload['exp'] = time() + ($minutosExpiracion * 60);

        $headerCodificado = self::base64UrlEncode(json_encode($header));
        $payloadCodificado = self::base64UrlEncode(json_encode($payload));

        $firma = hash_hmac(
            'sha256',
            $headerCodificado.'.'.$payloadCodificado,
            self::claveSecreta(),
            true
        );
        $firmaCodificada = self::base64UrlEncode($firma);

        return $headerCodificado.'.'.$payloadCodificado.'.'.$firmaCodificada;
    }

    /**
     * Valida un JWT: revisa que la firma sea correcta y que no esté expirado.
     * Devuelve el payload (arreglo) si es válido, o null si no lo es.
     */
    public static function validar(string $token): ?array
    {
        $partes = explode('.', $token);

        if (count($partes) !== 3) {
            return null;
        }

        [$headerCodificado, $payloadCodificado, $firmaCodificada] = $partes;

        $firmaEsperada = hash_hmac(
            'sha256',
            $headerCodificado.'.'.$payloadCodificado,
            self::claveSecreta(),
            true
        );
        $firmaEsperadaCodificada = self::base64UrlEncode($firmaEsperada);

        if (! hash_equals($firmaEsperadaCodificada, $firmaCodificada)) {
            return null;
        }

        $payload = json_decode(self::base64UrlDecode($payloadCodificado), true);

        if (! $payload || ! isset($payload['exp'])) {
            return null;
        }

        if ($payload['exp'] < time()) {
            return null;
        }

        return $payload;
    }
}