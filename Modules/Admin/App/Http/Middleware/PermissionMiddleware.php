<?php

namespace Modules\Admin\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Admin\App\Models\Admin;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        $allow = Admin::hasPermission($permission);

        return $allow ? $next($request) : abort(403, 'Unauthorized Action');
    }
}
