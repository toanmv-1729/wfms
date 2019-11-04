<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_time' => now(),
        ]);
        if ($user->is_admin && $user->user_type === config('user.type.admin')) {
            return redirect()->route('company.index');
        } elseif ($user->user_type === config('user.type.company')) {
            return redirect()->route('staffs.index');
        } else {
            return redirect()->route('projects.index');
        }
    }

    public function index()
    {
        return redirect()->route('login');
    }

    public function showLoginForm()
    {
        return view('auth.index');
    }

    /**
     * Update login time
     *
     * @param User $user
     * @return void
     */
    private function updateLoginTime(User $user): void
    {
        $user->update([
            'last_login_time' => Carbon::now(),
        ]);
    }
}
