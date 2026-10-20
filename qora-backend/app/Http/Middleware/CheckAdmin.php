<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Jika user yang login role-nya bukan 'admin', usir!
    if ($request->user() && $request->user()->role !== 'admin') {
        return response()->json([
            'message' => 'Access Denied! Only Admin can perform this action.'
        ], 403);
    }

    return $next($request);
}
}
