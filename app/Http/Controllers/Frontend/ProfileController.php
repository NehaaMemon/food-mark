<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileUpdatePasswordRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Traits\fileuploadtriat;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use fileuploadtriat;
    function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {


        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toastr()->success('Profile Update Successfully');
        return redirect()->back();
    }
    function updatePassword(ProfileUpdatePasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        toastr('password change', 'success');

        return redirect()->back();
    }
    function updateAvatar(Request $request)
    {


        $imagePath = $this->uploadImage($request, 'avatar');
        $user = Auth::user();
        $user->avatar = $imagePath;
        $user->save();
        return response(['status' => 'success', 'message' => 'Avatar Updated Successfully']);
    }
}
