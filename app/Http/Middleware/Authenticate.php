<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): \Illuminate\Http\JsonResponse|string|null
    {
        return response()->json('Unauthorized', 401);
    }

    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Error code response for missing or invalid authentication token.', $guards, $this->redirectTo($request)
        );
    }
}
