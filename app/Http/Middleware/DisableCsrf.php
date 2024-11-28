<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class DisableCsrf extends BaseVerifier
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
    protected $except = [
        '/api/cart/remove', // Thêm đường dẫn của bạn vào đây
    ];
}
