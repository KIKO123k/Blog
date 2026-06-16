<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAuthor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !in_array($request->user()->role, ['author', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Author access required.',
            ], 403);
        }

        return $next($request);
    }
}