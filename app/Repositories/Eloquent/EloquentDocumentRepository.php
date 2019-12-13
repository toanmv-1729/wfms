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
}
