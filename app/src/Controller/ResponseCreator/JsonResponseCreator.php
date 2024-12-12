<?php

namespace App\Controller\ResponseCreator;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonResponseCreator
{
    public static function create(int $httpCode, array|string $data): JsonResponse
    {
        return new JsonResponse([
            'code'   => $httpCode,
            'status' => $httpCode >= 200 && $httpCode <= 299 ? 'success' : 'error',
            'data'   => $data
        ], $httpCode);
    }
}