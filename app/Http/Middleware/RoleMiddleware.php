<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleMiddleware
{
    /**
     * Handle an incoming request and check that user has specified role
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(
        Request $request,
        Closure $next,
                $role
    ): Response
    {
        $user = JWTAuth::parseToken()->authenticate();
        $currentUserRole = Role::find($user->role_id);

        if ($currentUserRole->name !== $role) {
            abort(404);
        }

        return $next($request);
    }
}
