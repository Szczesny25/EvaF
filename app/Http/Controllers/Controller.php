<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'API',
    description: 'api para ver el tema del coso delcoso sobre el cosito(es de comprar cosas)'
)]
#[OA\Server(
    url: '/api',
    description: 'LA api'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'el token de segiruda'
)]
abstract class Controller
{
    //
}