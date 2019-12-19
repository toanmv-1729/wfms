<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;
use App\Contracts\Repositories\UserRepository;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    public function getProfile()
    {
        $this->authorize('users.getProfile');
        $user = $this->user;

        return view('users.profile', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request, $id, UserService $userService)
    {
        $this->authorize('users.updateProfile');
        $user = $this->user;
        $result = ($user->id == $id) && $userService->updateProfile($user, $request->all());
        $result ? toastr()->success('Profile Successfully Updated') : toastr()->error('Profile Updated Error');

        return redirect()->route('users.profile');
    }

    public function updatePassword(Request $request)
    {
        $this->authorize('users.updatePassword');
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        $hashedPassword = $this->user->password;
        if (Hash::check($request->old_password,$hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                $this->user->update([
                    'password' => Hash::make($request->password),
                ]);
                toastr()->success('Password Successfully Updated, Please Login Again');
                Auth::logout();
                return redirect()->route('login');
            } else {
                toastr()->error('New password cannot be the same as old password');
                return redirect()->route('users.profile');
            }
        } else {
            toastr()->error('Old password not match');
            return redirect()->route('users.profile');
        }
    }
}
