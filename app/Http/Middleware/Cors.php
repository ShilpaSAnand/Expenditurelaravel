<?php

namespace App\Http\Middleware;

use Closure;
use Log;
class Cors
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

      Log::info('hhhhhhhh');
      return $next($request)

    ->header('Access-Control-Allow-Origin','*')

    ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE, PATCH')

    ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin, Authorization, withCredentials');
    }
}
