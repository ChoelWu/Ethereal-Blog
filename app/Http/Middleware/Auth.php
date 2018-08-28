<?php

namespace App\Http\Middleware;

use Closure;

class Auth
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
        $user_session = base64_decode(json_decode(session('user')));
        $has_privileges = !empty($user_session['user_id']);
        $is_ajax = $request->ajax();
        if (!$has_privileges && !$is_ajax) {
            var_dump
            return redirect('/');
        }

        return $next($request);
    }

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
