<?php

namespace App\Http\Middleware;

use Closure;

class Permission
{
    public function handle($request, Closure $next, $permission)
    {
        $userAssignedPermissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();

        if(!in_array($permission, $userAssignedPermissions))
            abort(403);

        return $next($request);
    }
}
