<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = Auth::guard($guard)->user()->role;

                return match($role) {
                    'admin'    => redirect('/admin/pedidos'),
                    'employee' => redirect('/employee/pedidos'),
                    'client'   => redirect('/client/dashboard'),
                    default    => redirect(RouteServiceProvider::HOME),
                };
            }
        }

        return $next($request);
    }
}
