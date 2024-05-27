<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Customs\Services\JwtTokenService;
use App\Models\User;
use Carbon\Carbon;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwtService = new JwtTokenService;

        if (!$request->hasHeader('Authorization')) {
            return response()->json([
                'status' => 'failed',
                'error' => 'Authorization header missing'
            ], 401);
        }

        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);

        $tokenData =  $jwtService->decode($token);

        /**
         * for testing
         */

        // return response()->json([
        //     'status' => 'failed',
        //     'error' => $tokenData->data->role
        // ], 401);

        /**
         * end testing
         *
         */

         $now_time = Carbon::now()->timestamp;

         if ($tokenData->exp < $now_time) {
           return response()->json([
            'status'=> 'failed',
            'error'=> 'token expired'
           ]);
        }

        $user_id = $tokenData->sub;

        $user = User::where('id', $user_id)->first();
        if (!$user) {
            return response()->json([
                'status'=> 'failed',
                'error'=> 'User Not Found '
            ]);
        }

        return $next($request);
    }
}
