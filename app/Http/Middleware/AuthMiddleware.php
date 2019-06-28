<?php

namespace App\Http\Middleware;

use Closure;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        $jwtAuth=new \JwtAuth();
        $checkToken=$jwtAuth->checkToken($token);
        if ($checkToken) {
            return $next($request);
        } else {
            $data = [
              // Forbidden
              'code' => 403,
              'status'=>'error',
              'message'=>'El usuario no esta identificado.',
              'request' => $request
            ];
            return response()->json($data, $data['code']);
        }
    }
}
