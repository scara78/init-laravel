<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if (Auth()->user() &&  Auth()->user()->role == 'admin') {
            return $next($request);
        }else if(Auth()->check()){
            Auth()->logout();
        }
        
        return redirect('/')->with('message', 'You do not have the permissions to access this route');
    }
}
