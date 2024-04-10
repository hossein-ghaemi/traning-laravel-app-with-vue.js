<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AccessController extends Controller
{
    //

    public function updateAccessRoutes()
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $role = $route->getAction('role');
            if ($role) {
                $role_data = Role::where('nick_name', $role)->first();
                if ($role_data) {

                    $role_id = $role_data->id;
                    $route_name = $route->getName();
                    if (!Access::where('route', $route_name)->exists()) {

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

                    } else {

                        $title = $route->getAction('title');
                        $status = $route->getAction('status');
                        $def_access = $route->getAction('def_access');

                        $access = [
                            'role_id' => $role_id,
                        ];

                        if ($title) $access['title'] = $title;
                        if ($status != null) $access['status'] = $status;
                        if ($def_access != null) $access['def_access'] = $def_access;


                        Access::where('route', $route_name)->update($access);

                    }
                }
            } else {
                $route_name = $route->getName();
                Access::where('route', $route_name)->delete();
            }
        }
    }

}
