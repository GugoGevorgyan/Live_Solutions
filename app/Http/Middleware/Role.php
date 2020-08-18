<?php

namespace App\Http\Middleware;

use Closure;

class Role
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
// print_r(auth()->user()->role_id);
//        if (auth()->user()->role_id === 1){
//            return 'admin dashboard midlleware';
//        }
        return $next($request);
    }
}
