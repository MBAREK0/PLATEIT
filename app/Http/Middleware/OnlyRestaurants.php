<?php

namespace App\Http\Middleware;

use App\Customs\Services\JwtTokenService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyRestaurants
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwtService = new JwtTokenService;
        $token = $request->header('Authorization');
        $role = $jwtService->get_role($token);


        if ($role != 'restaurant') {
            return response()->json([
                'status' => 'failed',
                'error' => 'Authorization failed'
            ], 403);
        }
        return $next($request);
    }
}
