<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

            $fName = $request->input('fName');
            $lName = $request->input('lName');
            $email = $request->input('email');
            $phoneNumber = $request->input('phoneNumber');
            $roles = explode(',', $request->input('roles'));

            $user = User::find($userId);
            $user->fName = $fName;
            $user->lName = $lName;
            $user->email = $email;
            $user->phoneNumber = $phoneNumber;
            $user->roles()->sync($roles);
            $user->save();
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $dateUploaded = now()->format('Y-m-d_H-i-s');

                $fileName = 'profile_' . $userId . '_' . $dateUploaded . '.' . $file->getClientOriginalExtension();
                $directory = 'profile_pictures/user_' . $userId;
                Storage::disk('public')->deleteDirectory($directory);
                Storage::disk('public')->makeDirectory($directory);
                $path = $file->storeAs('profile_pictures/user_' . $userId, $fileName, 'public');
                $fullPath = Storage::disk('public')->url($path);
                $userInfo = UserInfo::where('user_id', $userId)->first();
                if (!$userInfo) {
                    $userInfo = new UserInfo();
                    $userInfo->user_id = $userId;
                }
                $userInfo->profile = $fullPath;
                $userInfo->save();
                return response()->json(['path' => $fullPath]);
            }
            return json_encode(['message'=>trans('global.success_attempt')]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating profile.'], 500);
        }
    }

}
