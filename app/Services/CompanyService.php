<?php

namespace App\Services;

use DB;
use App\Models\User;
use App\Models\Media;
use App\Helpers\ContentsHelper;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\CompanyRepository;

class CompanyService
{
    const IMAGE_DIRECTORY = 'image/companies/';

    protected $userRepository;
    protected $companyRepository;

    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository) {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    public function storeCompanyAndUser(User $user, $data)
    {
        if (isset($data['image'])) {
            DB::beginTransaction();
            $company = $this->companyRepository->create([
                'name' => $data['name'],
            ]);
            $userCompany = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['name'],
                'password' => bcrypt($data['name']),
                'is_admin' => false,
                'user_type' => 'company',
                'created_by' => $user->id,
                'company_id' => $company->id,
            ]);
            try {
                $this->uploadCompanyImage($userCompany, $data['image']);
                DB::commit();
            } catch (Exception $exception) {
                app(ExceptionHandler::class)->report($exception);
                DB::rollBack();
            }
        } else {
            $company = $this->companyRepository->create([
                'name' => $data['name'],
            ]);
            $userCompany = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['name'],
                'password' => bcrypt($data['name']),
                'is_admin' => false,
                'user_type' => 'company',
                'created_by' => $user->id,
                'company_id' => $company->id,
            ]);
        }
    }

    /**
     * @param $user
     * @param \Illuminate\Http\UploadedFile $backgroundImage
     * @return null|mixed
     */
    public function uploadCompanyImage($user, $backgroundImage)
    {
        $fileName = sprintf('%s-%s', ContentsHelper::getUniqueContentName($user->id), $backgroundImage->hashName());
        $content = ContentsHelper::storeImageWithPreview(
            $backgroundImage,
            self::IMAGE_DIRECTORY,
            $fileName
        );

        $media = $user->media()->create([
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
