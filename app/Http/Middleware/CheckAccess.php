<?php

namespace App\Http\Middleware;

use App\Models\Access;
use App\Models\UserAccess;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        $current_route = $request->path();
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
