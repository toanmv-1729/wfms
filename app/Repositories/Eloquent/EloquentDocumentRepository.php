<?php

namespace App\Repositories\Eloquent;

use App\Models\Document;
use App\Contracts\Repositories\DocumentRepository;

class EloquentDocumentRepository extends EloquentRepository implements DocumentRepository
{
    public function __construct(Document $model)
    {
        parent::__construct($model);
    }

    /**
     * Get Root Document In Project
     * @param int $projectId
     * @param array $columns
     * @return Collection
     */
    public function getRootItemsInProject($projectId, $columns = ['*'])
    {
        return $this->model
            ->where('project_id', $projectId)
            ->whereNull('parent_id')
            ->get($columns);
    }

    /**
     * Get Child Document In Project
     * @param int $projectId
     * @param int $parentId
     * @param array $columns
     * @return Collection
     */
    public function getChildDocuments($projectId, $parentId, $columns = ['*'])
    {
        return $this->model
            ->where('project_id', $projectId)
            ->where('parent_id', $parentId)
            ->get($columns);
    }

    /**
     * Get Breadcrumb Documents
     * @param array $parentIds
     * @param array $columns
     * @return Collection
     */
    public function getBreadcrumbDocuments(array $parentIds, $columns = ['*'])
    {
        return $this->model
            ->whereIn('id', $parentIds)
            ->get();
    }
}
