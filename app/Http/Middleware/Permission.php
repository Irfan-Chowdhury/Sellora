<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permission
{
    public function handle($request, Closure $next, $permission)
    {
        $userAssignedPermissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();

        if(!in_array($permission, $userAssignedPermissions))
            abort(403, '403 | Unauthorized');

        return $next($request);
    }
}
