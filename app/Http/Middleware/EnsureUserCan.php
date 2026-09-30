<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCan
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $ability): Response
    {
        $user = $request->user();

        abort_unless(
            $user && method_exists($user, $ability) && $user->{$ability}(),
            403,
            'You are not allowed to access this page.'
        );

        return $next($request);
    }
}
