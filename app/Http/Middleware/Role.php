<?php

namespace App\Http\Middleware;

use Closure;

class role
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
        if (1==1){
            dd(auth()->user()->role_id);
//        return  "midlawere";
    }

//        if (auth()->user()->role_id === 1){
//            return 'admin dashboard midlleware';
//        }
        return $next($request);
    }
}
