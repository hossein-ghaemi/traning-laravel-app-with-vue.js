<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Get the authenticated user
            $token = $user->createToken('auth-login')->token;
            return response()->json(['token' => $token], 200);
        }
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')]
        ]);
    }



}
