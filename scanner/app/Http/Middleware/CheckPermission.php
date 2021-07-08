<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Role\RolesPermissionsController;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission_slug)
    {
        $routeName = $request->route()->getName();
        // Log::info('permission slug ' . $permission_slug . ' route name - ' . $routeName);
        $rolesPermissionsController = new RolesPermissionsController();
        $checkUserPermission = $rolesPermissionsController->checkUserPermission($permission_slug);
        // Log::info($checkUserPermission);
        if (!$checkUserPermission) {
            // $is_ajax = $request->ajax();
            if ($request->ajax()) {
                $response =  array(
                    'status'  =>  'forbidden',
                    'code'    => 403,
                    'message'   =>  'You don’t have permission to access this page',
                );
                return response()->json($response);
            }
            return redirect('/forbidden');
        }
        return $next($request);
    }
}
