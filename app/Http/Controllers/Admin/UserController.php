<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserList(Request $request){
        return json_encode(['users'=>User::all()]);
    }

    public function loadUserProfile($id){
        var_dump($id);
    }
}
