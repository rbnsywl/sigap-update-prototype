<?php

namespace App\Http\Middleware;

use App\Support\Roles;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * Mock auth middleware for the prototype.
 * Reads the active role from the session and shares user/sidebar/notifications
 * with every authenticated view. Swap for Laravel's real `auth` middleware later.
 */
class MockAuth
{
    public function handle(Request $request, Closure $next)
    {
        $role = session('role');

        if (! $role || ! Roles::user($role)) {
            return redirect('/login');
        }

        $user = Roles::user($role);

        View::share('user', $user);
        View::share('sidebar', Roles::sidebar($role));
        View::share('notifications', \App\Support\MockData::notifications($role));

        return $next($request);
    }
}
