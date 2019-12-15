<?php

namespace App\Contracts\Repositories;

interface SampleDescriptionRepository extends Repository
{
    /**
     * Update Status all sample in project
     * @param int $projectId
     * @return Boolean
     */
    public function updateStatus(int $projectId);
}
