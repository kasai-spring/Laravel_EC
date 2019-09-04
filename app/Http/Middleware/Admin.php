<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use Closure;

class Admin
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
        if(!session()->has("login_id") || !session()->has("Admin")){
            return redirect()
                ->route("error");
        }
        return $next($request);
    }
}
