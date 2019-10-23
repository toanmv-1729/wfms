<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Staff\StoreRequest;
use App\Contracts\Repositories\UserRepository;

class StaffController extends Controller
{
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $user = $this->user;
        return view('staffs.index', compact('user'));
    }

    public function store(StoreRequest $request)
    {
    }

    public function update()
    {
    }

    public function destroy(Request $request, $id)
    {
    }
}
