<?php

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Auth;

use Closure;

class User
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
        if(Auth::user()->role != 'user'){
            return redirect()->route('login');
        }
        else{
            return $next($request);
        }
    }
}
