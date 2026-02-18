<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('authenticated_user')) {
            return redirect()->route('landing');
        }

        return $next($request);
    }
}
