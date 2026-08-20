<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use App\Models\RoleModulePermission;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $roleModulePermission = RoleModulePermission::where('role_id', \Auth::user()->role_id)->pluck('module_permission_name');
        $permissions = Session::get('permissions')->toArray();

        if (count($roleModulePermission) !== count($permissions)) {
            Session::put('permissions', $roleModulePermission);
            return redirect('/permission-updated');
        } else {
            $route = $request->route();
            $module_being_accessed = str_replace($route->getPrefix() . '/', "", $route->uri());
            $module_being_accessed = explode("/", $module_being_accessed)[0];
            $permission_being_accessed = $route->getActionMethod();
            if ($permission_being_accessed === 'edit') {
                $permission_being_accessed = 'update';
            } else if ($permission_being_accessed === 'create') {
                $permission_being_accessed = 'store';
            }

            $check = $module_being_accessed . '_' . $permission_being_accessed;

            if (in_array($check, Session::get('permissions')->toArray()) || $check === "dashboard_index") {
                return $next($request);
            } else {
                if (\Auth::user()->role_id === 2) {
                    return redirect('/');
                }
                return $next($request);
            }
        }
        return $next($request);
    }
}
