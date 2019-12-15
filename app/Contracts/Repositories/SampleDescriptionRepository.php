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

    /**
     * Find Sample Active Apply In Project
     * @param int $projectId
     * @return Collection
     */
    public function findActiveSampleInProject(int $projectId);
}
