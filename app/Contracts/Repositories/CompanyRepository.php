<?php

namespace App\Contracts\Repositories;

interface CompanyRepository extends Repository
{
    public function getAllWithUsers($columns = ['*']);
}
