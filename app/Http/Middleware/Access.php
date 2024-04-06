<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as request_facades;
use Symfony\Component\HttpFoundation\Response;


class Access
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (self::access()){
            return $next($request);
        }

        return redirect()->route('/login');

    }

    public static function access()
    {

        $role = 'all';

        $check = Auth::check();
        $user = Auth::user();

        if ($check && ($user->role == $role || $role == "all")) {

            if ($user['profile']) {
                $user->file_path = request_facades::root() . '/' . $user['profile']['file_path'];
            } else {
                $user->file_path = request_facades::root() . '/images/user-icon.png';
            }
            $user->save();
            return true;
        } else {
            return false;
        }
    }

}
