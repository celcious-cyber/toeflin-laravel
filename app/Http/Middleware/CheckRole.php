<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            // Arahkan ke halaman login yang sesuai berdasarkan route yang diminta
            if ($role === 'admin' || $role === 'superadmin') {
                return redirect()->route('admin.login');
            }
            return redirect()->route('student.login');
        }

        $userRole = auth()->user()->role;

        // Admin dan superadmin bisa akses route admin
        if ($role === 'admin' && in_array($userRole, ['admin', 'superadmin'])) {
            return $next($request);
        }

        // Superadmin bisa akses semua
        if ($userRole === 'superadmin') {
            return $next($request);
        }

        if ($userRole !== $role) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
