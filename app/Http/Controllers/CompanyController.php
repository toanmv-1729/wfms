<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Requests\Company\StoreRequest;
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

    public function index()
    {
        $companies = $this->companyRepository->getAllWithUsers();

        return view('companies.index', compact('companies'));
    }

    public function store(StoreRequest $request, CompanyService $companyService)
    {
        $companyService->storeCompanyAndUser($this->user, $request->all());
        toastr()->success('Company Successfully Created');

        return redirect()->route('company.index');
    }

    public function update()
    {
        //
    }

    public function destroy(Request $request, $id)
    {
        $company = $this->companyRepository->find($id);
        if (!$this->user || !$this->user->is_admin) {
            toastr()->error('You are not authorized to access this action');

            return redirect()->route('company.index');
        } elseif (!$company) {
            toastr()->error('Company not exists');

            return redirect()->route('company.index');
        } else {
            foreach($company->users as $user) {
                $user->update([
                    'email' => now()->format('YmdHis') . $user->email,
                ]);
                $user->delete();
            }
            $company->delete();
            toastr()->success('Company successfully deleted');

            return redirect()->route('company.index');
        }
    }
}
