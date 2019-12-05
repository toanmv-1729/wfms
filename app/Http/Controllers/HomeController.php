<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->user->update([
            'last_login_time' => now(),
        ]);
        if ($this->user->is_admin && $this->user->user_type === config('user.type.admin')) {
            return redirect()->route('company.index');
        } elseif ($this->user->user_type === config('user.type.company')) {
            return redirect()->route('staffs.index');
        } else {
            return redirect()->route('staffs.my_projects');
        }
    }
}
