<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateJsonRequest
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader('Accept') || !str_contains($request->header('Accept'), 'application/json'))
        {
            return response()->json([
                'message' => 'Requests must have Accept as application/json.',
            ], 415);
        }

        return $next($request);
    }
}
