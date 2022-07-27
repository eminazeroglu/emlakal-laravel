<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceUserToAcceptJson
{
    public function handle(Request $request, Closure $next)
    {
        $acceptHeader = strtolower($request->headers->get('accept'));

        if ('application/json' !== $acceptHeader):
            $request->headers->set('Accept', 'application/json');
        endif;

        return $next($request);
    }
}
