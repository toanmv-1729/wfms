<?php

namespace App\Repositories\Eloquent;

use App\Models\SampleDescription;
use App\Contracts\Repositories\SampleDescriptionRepository;

class EloquentSampleDescriptionRepository extends EloquentRepository implements SampleDescriptionRepository
{
    public function __construct(SampleDescription $model)
    {
        parent::__construct($model);
    }

    /**
     * Update Status all sample in project
     * @param int $projectId
     * @return Boolean
     */
    public function updateStatus(int $projectId)
    {
    	return $this->model
    		->where('project_id', $projectId)
    		->where('status', 1)
    		->update(['status' => 0]);
    }
}
