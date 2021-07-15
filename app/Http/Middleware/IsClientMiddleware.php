<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( auth()->user()->is_admin == 0 ) return $next($request);

        return response()->json([
            'message' => 'No tiene permisos para realizar ésta operación.'
        ], Response::HTTP_FORBIDDEN);
    }
}
