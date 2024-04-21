<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Get the authenticated user
            $token = $user->createToken('auth-login')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user // Include user information in the response
            ], 200);
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')]
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all())->validate();
        if ($validator) {
            $user = $this->create($request->all());

            Auth::login($user);


            $user = Auth::user(); // Get the authenticated user
            $token = $user->createToken('auth-login')->token;
            return response()->json(['token' => $token], 200);

        }
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')]
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            "email" => ["required", "string", "email", "max:255", "unique:users"],
            "password" => ["required", "string", "min:8", "confirmed"],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            "role_id" => 1,
            "email" => $data["email"],
            "password" => Hash::make($data["password"]),
        ]);
    }


}
