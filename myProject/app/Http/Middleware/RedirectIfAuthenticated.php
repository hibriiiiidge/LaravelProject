<?php

namespace App\Http\Middleware;

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
      //新規ユーザ登録時にそのまま登録ユーザとしてログインする処理
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/home');
        // }
        return $next($request);
    }
}
