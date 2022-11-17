<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;

class RedirectRegister extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if($request->session()->get('authenticated') != true)

            $request->session()->put('intendedView', 'subscribe');
            $request->session()->save();

            return redirect("/signup");

        return $next($request);
    }
    
}