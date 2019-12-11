<?php

namespace App\Services;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Version;
use Illuminate\Contracts\Debug\ExceptionHandler;
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
            'description' => array_get($data, 'description'),
            'start_date' => $startDate,
            'due_date' => $dueDate,
        ]);
        if ($version) {
            return true;
        }

        return false;
    }

    /**
     * Update Object Version
     * @param User $user
     * @param Version $version
     * @param array $data
     * @return Boolean
     */
    public function update(User $user, Version $version, $data)
    {
        $date = explode('-', array_get($data, 'daterange'));
        $startDate = Carbon::parse($date[0])->format('Y-m-d');
        $dueDate = Carbon::parse($date[1])->format('Y-m-d');

        try {
            $version->update([
                'name' => array_get($data, 'name') ?? $version->name,
                'description' => array_get($data, 'description') ?? $version->description,
                'start_date' => $startDate ?? $version->start_date,
                'due_date' => $dueDate ?? $version->due_date,
            ]);

            return true;
        } catch (Exception $exception) {
            app(ExceptionHandler::class)->report($exception);
            return false;
        }
    }
}
