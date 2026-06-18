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
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;
        
        if ($role === 'admin' && in_array($userRole, ['admin', 'superadmin'])) {
            return $next($request);
        }

        if ($userRole !== $role) {
            abort(403, 'Unauthorized access.');
        }
        
        return $next($request);
    }
}
