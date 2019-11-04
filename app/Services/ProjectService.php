<?php

namespace App\Services;

use DB;
use App\Models\User;
use App\Models\Media;
use App\Helpers\ContentsHelper;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\ProjectRepository;
use Illuminate\Contracts\Debug\ExceptionHandler;

class ProjectService
{
    const IMAGE_DIRECTORY = 'image/projects/';

    protected $userRepository;
    protected $projectRepository;

    public function __construct(
        UserRepository $userRepository,
        ProjectRepository $projectRepository
    ) {
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
    }

    public function store(User $user, $data)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->create([
                'company_id' => $user->company_id,
                'name' => $data['name'],
                'description' => $data['description'],
                'root_folder_link' => $data['root_folder_link'],
                'repository_link' => $data['repository_link'],
            ]);
            foreach ($data['users'] as $roleId => $value) {
                $project->users()->attach($value, ['role_id' => $roleId]);
            }
            if (isset($data['image'])) {
                $this->uploadProjectImage($project, $data['image']);
            }
            DB::commit();
        } catch (Exception $exception) {
            app(ExceptionHandler::class)->report($exception);
            DB::rollBack();
        }
    }

    /**
     * @param $project
     * @param \Illuminate\Http\UploadedFile $backgroundImage
     * @return null|mixed
     */
    public function uploadProjectImage($project, $backgroundImage)
    {
        $fileName = sprintf('%s-%s', ContentsHelper::getUniqueContentName($project->id), $backgroundImage->hashName());
        $content = ContentsHelper::storeImageWithPreview(
            $backgroundImage,
            self::IMAGE_DIRECTORY,
            $fileName
        );

        $media = $project->media()->create([
            'name' => $backgroundImage->getClientOriginalName(),
            'path' => array_get($content, 'originalContentUrl'),
            'extension' => $backgroundImage->getClientOriginalExtension(),
            'size' => $backgroundImage->getSize(),
            'type' => Media::TYPE_IMAGE,
            'mime_type' => $backgroundImage->getMimeType(),
            'preview_path' => array_get($content, 'previewImageUrl'),
        ]);

        return $media;
    }
}
