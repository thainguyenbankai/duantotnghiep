<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->status == 'admin') {
                return $next($request);
            } else {
                return redirect()->route('dashboard');
            }
        }


        return redirect()->route('login'); // Người dùng chưa đăng nhập chuyển hướng đến trang đăng nhập
    }
}
