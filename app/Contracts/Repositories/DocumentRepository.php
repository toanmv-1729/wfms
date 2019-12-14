<?php

namespace App\Contracts\Repositories;

interface DocumentRepository extends Repository
{
    /**
     * Get Root Document In Project
     * @param int $projectId
     * @param array $columns
     * @return Collection
     */
    public function getRootItemsInProject($projectId, $columns = ['*']);

    /**
     * Get Child Document In Project
     * @param int $projectId
     * @param int $parentId
     * @param array $columns
     * @return Collection
     */
    public function getChildDocuments($projectId, $parentId, $columns = ['*']);

    /**
     * Get Breadcrumb Documents
     * @param array $parentIds
     * @param array $columns
     * @return Collection
     */
    public function getBreadcrumbDocuments(array $parentIds, $columns = ['*']);
}
