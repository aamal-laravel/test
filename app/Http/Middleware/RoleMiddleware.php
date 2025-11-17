<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Expects roles as middleware parameters, e.g. ->middleware([RoleMiddleware::class.':tourist'])
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if (! $role) {
            return $next($request);
        }

        $ok = false;
        if ($role === 'tourist') {
            $ok = (bool) $user->tourist()->exists();
        } elseif ($role === 'provider') {
            $ok = (bool) $user->provider()->exists();
        } elseif ($role === 'admin') {
            // admin flag not present in migrations; rely on is_admin boolean on users or fallback to false
            $ok = (bool) ($user->is_admin ?? false);
        }

        if (! $ok) {
            return response()->json(['message' => 'Forbidden - role: '.$role], 403);
        }

        return $next($request);
    }
}
