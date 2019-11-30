<?php

namespace App\Services;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Contracts\Repositories\VersionRepository;

class VersionService
{
    protected $versionRepository;

    public function __construct(
        VersionRepository $versionRepository
    ) {
        $this->versionRepository = $versionRepository;
    }

    /**
     * Store Object Version
     * @param User $user
     * @param array $data
     * @return Boolean
     */
    public function store(User $user, $data)
    {
        $date = explode('-', array_get($data, 'daterange'));
        $startDate = Carbon::parse($date[0])->format('Y-m-d');
        $dueDate = Carbon::parse($date[1])->format('Y-m-d');
        $version = $this->versionRepository->create([
            'user_id' => $user->id,
            'project_id' => array_get($data, 'project'),
            'name' => array_get($data, 'name'),
            'start_date' => $startDate,
            'due_date' => $dueDate,
        ]);
        if ($version) {
            return true;
        }

        return false;
    }
}
