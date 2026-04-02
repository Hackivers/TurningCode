<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if ($user->role !== $role) {
            return redirect()->route($user->role === 'admin' ? 'admin.spa' : 'user.spa');
        }

        return $next($request);
    }
}
