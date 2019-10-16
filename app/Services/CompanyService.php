<?php

namespace App\Services;

use App\Models\User;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\CompanyRepository;

class CompanyService
{
    protected $userRepository;
    protected $companyRepository;

    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository) {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    public function storeCompanyAndUser(User $user, $data)
    {
        $company = $this->companyRepository->create([
            'name' => $data['name'],
        ]);
        $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['name'],
            'password' => bcrypt($data['name']),
            'is_admin' => false,
            'user_type' => 'company',
            'created_by' => $user->id,
            'company_id' => $company->id,
        ]);
    }
}
