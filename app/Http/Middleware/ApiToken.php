<?php

namespace App\Http\Middleware;

use Closure;
use Teepluss\Restable\Facades\Restable;

class ApiToken
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
        // Check token
        if (is_null($request->header('APP-TOKEN')) || $request->header('APP-TOKEN') != config('variables.APP_TOKEN')) {
            $arrResult['status'] = 'Unauthorized';
            $arrResult['status_code'] = '401';
            $arrResult['message'] = 'No direct script access allowed.';
            return response()->json($arrResult,401);
        }

        return $next($request);
    }
}
