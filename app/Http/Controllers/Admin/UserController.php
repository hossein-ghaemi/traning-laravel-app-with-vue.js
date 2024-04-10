<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getUserList(Request $request)
    {
        return json_encode(['users' => User::all()]);
    }

    public function loadUserProfile($id)
    {
        return json_encode(['user' => User::find($id)]);
    }

    public function updateProfile(Request $request)
    {
        try {
            $userId = $request->input('id');

            $f_name = $request->input('f_name');
            $l_name = $request->input('l_name');
            $email = $request->input('email');
            $phone_number = is_numeric($request->input('phone_number')) ? $request->input('phone_number') : '';
            $role = $request->input('role_id');

            $user = User::find($userId);
            $user->f_name = $f_name;
            $user->l_name = $l_name;
            $user->email = $email;
            $user->phone_number = $phone_number;
            $user->role_id = $role;
            $user->save();
            (new FileController())->upload($request, $user->id, 'users', $user->id, 'storage/profile_pictures/user_' . $userId . '/', 'image',key: 'profile_picture');
//            if ($request->hasFile('profile_picture')) {
//                $file = $request->file('profile_picture');
//                $dateUploaded = now()->format('Y-m-d_H-i-s');
//
//                $fileName = 'profile_' . $userId . '_' . $dateUploaded . '.' . $file->getClientOriginalExtension();
//                $directory = 'profile_pictures/user_' . $userId;
//                Storage::disk('public')->deleteDirectory($directory);
//                Storage::disk('public')->makeDirectory($directory);
//                $path = $file->storeAs('profile_pictures/user_' . $userId, $fileName, 'public');
//                $fullPath = Storage::disk('public')->url($path);
//                $userInfo = UserInfo::where('user_id', $userId)->first();
//                if (!$userInfo) {
//                    $userInfo = new UserInfo();
//                    $userInfo->user_id = $userId;
//                }
//                $userInfo->profile = $fullPath;
//                $userInfo->save();
//                return response()->json(['path' => $fullPath]);
//            }
            return json_encode(['message' => trans('global.success_attempt')]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
