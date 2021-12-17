<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::guard('users')->check() && auth('users')->user()->is_active) {
            return $next($request);
        } elseif (Auth::guard('users')->check()) {
            auth()->guard('users')->logout();
        }
        //return back();
        return redirect()->route('admin.login');
        //  return $next($request);
    }
}
