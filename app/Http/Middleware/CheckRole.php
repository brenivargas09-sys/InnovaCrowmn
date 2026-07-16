<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!empty($roles) && !in_array(Auth::user()->role, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        if (Auth::user()->status !== 'activo') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Tu cuenta está desactivada.');
        }

        return $next($request);
    }
}
