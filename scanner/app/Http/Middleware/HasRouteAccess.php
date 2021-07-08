<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\CustomLog;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Ngaggeproduct\ProductMenu;

class HasRouteAccess
{
    protected $exceptRoutes = [
        'forbidden'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->product_id != '1' && !$request->ajax()) {
            $user = Auth::user();
            $routeName = $request->route()->uri;
            if ($request->has('sub')) {
                $routeName .= '?sub=' . $request->get('sub');
                CustomLog::LOG('route with parameter ', $routeName);
            }
            // CustomLog::LOG('route name ', $routeName);
            $productMenu = new ProductMenu();
            $avlProductRoutes = $productMenu->getDirectRoute(explode(',', $user->product_id));
            // CustomLog::LOG('hasRouteAccess ', json_encode($avlProductRoutes, true));
            $exceptRoute = array_merge($this->exceptRoutes, $avlProductRoutes);
            if (!in_array($routeName, $exceptRoute)) {
                if ($request->ajax()) {
                    $response =  array(
                        'status'  =>  'forbidden',
                        'code'    => 403,
                        'message'   =>  'You don’t have access to this uri',
                    );
                    return response()->json($response);
                } else {
                    return redirect('/forbidden');
                }
            }
        }
        return $next($request);
    }
}
