<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getAllRoles()
    {
        return json_encode(['roles' => Role::all()]);
    }

}
