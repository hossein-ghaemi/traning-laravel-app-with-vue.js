<?php

namespace App\Http\Middleware;

use App\Models\Access;
use App\Models\UserAccess;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {

        if (self::access($request)) {
            return $next($request);
        }


        return redirect('/register');

    }

    private function access($request)
    {

        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $route_name = $route->getName();
            if (!Access::where('route', $route_name)->exists()) {
                $role_id = $route->getAction('role_id');
                if ($role_id) {
                    $title = $route->getAction('title');
                    $status = $route->getAction('status');
                    $def_access = $route->getAction('def_access');

                    $access = [
                        'route' => $route_name,
                        'role_id' => $role_id,
                    ];

                    if ($title) $access['title'] = $title;
                    if ($status != null) $access['status'] = $status;
                    if ($def_access != null) $access['def_access'] = $def_access;


                    Access::create($access);
                }
            }
        }

//        dd(Route::getCurrentRoute()->getAction());


//        $parameters = $request->route()->parameters();
//        $current_route = $request->path();
//        $route = $request->route()->getName();

        $current_route = $request->route()->getName();

        $exist_access = Access::where('route', $current_route)->exists();
        $host = $request->host();

        if ($exist_access && Auth::check()) {
            $user = Auth::user();

            $access_route_role = Access::where('route', $current_route)->where('role_id', $user->role_id)->first();
            if ($access_route_role) {
                $user_access = UserAccess::where('user_id', $user->id)->where('access_id', $access_route_role->id)->exists();
                if ($access_route_role->def_access && $user_access) {
                    return false;
                } else if (!$access_route_role->def_access && !$user_access) {
                    return false;
                }
            } else {
                return false;
            }


            if ($user->profile && isset($user->profile->fil_path)) {
                $user->file_path = $host . '/' . $user->profile->fil_path;
            } else {
                $user->file_path = $host . '/images/user-icon.png';
            }

            return true;
        } else if(!$exist_access && Auth::check()){

            $user = Auth::user();


            if ($user->profile && isset($user->profile->fil_path)) {
                $user->file_path = $host . '/' . $user->profile->fil_path;
            } else {
                $user->file_path = $host . '/images/user-icon.png';
            }

            return true;
        } else if(!$exist_access){
            return true;
        } else {
            return false;
        }
    }

}
