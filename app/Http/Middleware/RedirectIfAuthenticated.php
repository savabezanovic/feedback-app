<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if (\auth()->user()->role[0]->name == "superadmin") {

                return redirect('/superadmin');
            }

            else if (\auth()->user()->role[0]->name == 'admin') {

                return redirect('/admin');
            }

            return redirect('/dashboard');
        }

        return $next($request);
    }
}
