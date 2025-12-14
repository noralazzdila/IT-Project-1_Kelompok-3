<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth; // ✅ ini yang benar

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        if (Auth::user()->role !== $role) {
            // Log the details before aborting
            \Illuminate\Support\Facades\Log::warning(
                'Role mismatch for user ' . \Illuminate\Support\Facades\Auth::id() . ' (' . \Illuminate\Support\Facades\Auth::user()->role . '). ' .
                'Required role: ' . $role . ' for route: ' . $request->path()
            );
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
