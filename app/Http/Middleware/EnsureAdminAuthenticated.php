<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('admin_auth')) {
            return $next($request);
        }

        if ($request->routeIs('admin.login') || $request->routeIs('admin.login.post') || $request->routeIs('admin.logout')) {
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}
