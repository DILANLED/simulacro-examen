<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle($request, Closure $next, ...$roles)
{
    $user = auth()->user();
    if (!$user) return redirect()->route('login.form');

    if (!in_array((string)$user->id_rol, $roles, true)) {
        abort(403);
    }
    return $next($request);
}

}
