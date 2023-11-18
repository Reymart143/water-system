<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Encoder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 0 = SuperAdmin
        // 1 = admin
        // 2 = treasurer
        // 3 = encoder
        // 4 = assessor
        if(Auth::check()){
            if(Auth::user()->role == '3'){
                return $next($request);
            }else{
                return redirect('/login')->with('message', 'Access Denied Superadmin Access Only!');
            }
        }else{
            return redirect('/login')->with('message', 'Please login first.');
        }
        return $next($request);
    }
}
