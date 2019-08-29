<?php

namespace App\Http\Middleware;

use Closure;

class NormalUser
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
        if(!session()->has("login_id")){
            return redirect()
            ->route("login");
        }
        return $next($request);
    }
}
