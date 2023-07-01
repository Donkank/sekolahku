<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    public function handle(Request $request, Closure $next, $userType): Response
    {
        if (auth()->guard('api')->user()->type == $userType) {
            return $next($request);
        }

        return response()->json([
            'success'   => false,
            'message'   => 'Anda tidak memiliki izin untuk mengakses halaman ini.'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
