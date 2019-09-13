<?php

namespace App\Http\Middleware;

use Closure;

class Publisher
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
        if(!session()->has("PublisherController")){
            return redirect()->route("login");
        }
        return $next($request);
    }
}
