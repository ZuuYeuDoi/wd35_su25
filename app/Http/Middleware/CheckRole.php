<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role_id, $roles)) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}
