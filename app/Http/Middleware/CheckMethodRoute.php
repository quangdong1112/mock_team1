<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckMethodRoute
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse|RedirectResponse|Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->method(), $request->route()->methods())) {
            return $next($request);
        } else {
            return response()->json([
                'status' => 'success',
                'code' => 405,
                'error' => 'Method not allowed',
            ], 405);
        }
    }
}
