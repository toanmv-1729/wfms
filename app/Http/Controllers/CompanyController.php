<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\CompanyRepository;

class CompanyController extends Controller
{
    protected $userRepository;
    protected $companyRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->companyRepository =$companyRepository;
    }

    public function store(Request $request, CompanyService $companyService)
    {
        $companyService->storeCompanyAndUser($this->user, $request->all());

        return redirect()->route('home');
    }
}
