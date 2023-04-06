<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Session\Store;
class CheckSessionExpiration
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
        $mySession = Session::get('email');
        if ($mySession) {
            if ($mySession instanceof \Illuminate\Session\Store && $mySession->isExpired()) {
                return redirect('/login')->with('error', 'Session expired. Please log in again.');
            }  
        }  
        return $next($request);
    }
}
