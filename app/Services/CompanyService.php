<?php

namespace App\Services;

use DB;
use App\Models\User;
use App\Models\Media;
use App\Helpers\ContentsHelper;
use App\Contracts\Repositories\UserRepository;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Contracts\Repositories\CompanyRepository;
use App\Notifications\SendAccountInfomationNotification;

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
        $password = str_random(12);
        if (isset($data['image'])) {
            DB::beginTransaction();
            $company = $this->companyRepository->create([
                'name' => $data['name'],
            ]);
            $userCompany = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($password),
                'is_admin' => false,
                'user_type' => 'company',
                'created_by' => $user->id,
                'company_id' => $company->id,
            ]);
            try {
                $this->uploadCompanyImage($company, $data['image']);
                DB::commit();
            } catch (Exception $exception) {
                app(ExceptionHandler::class)->report($exception);
                DB::rollBack();
            }
        } else {
            try {
                DB::beginTransaction();
                $company = $this->companyRepository->create([
                    'name' => $data['name'],
                ]);
                $userCompany = $this->userRepository->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($password),
                    'is_admin' => false,
                    'user_type' => 'company',
                    'created_by' => $user->id,
                    'company_id' => $company->id,
                ]);
                DB::commit();
            } catch (Exception $exception) {
                app(ExceptionHandler::class)->report($exception);
                DB::rollBack();
            }
        }
        if ($userCompany) {
            $userCompany->notify(new SendAccountInfomationNotification($userCompany->email, $password));
        }
        $datas = [];
        foreach (config('role.main_roles') as $value) {
            array_push($datas, [
                'user_id' => $userCompany->id,
                'name' => $value,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $userCompany->roles()->insert($datas);
    }

    /**
     * @param $company
     * @param \Illuminate\Http\UploadedFile $backgroundImage
     * @return null|mixed
     */
    public function uploadCompanyImage($company, $backgroundImage)
    {
        $fileName = sprintf('%s-%s', ContentsHelper::getUniqueContentName($company->id), $backgroundImage->hashName());
        $content = ContentsHelper::storeImageWithPreview(
            $backgroundImage,
            self::IMAGE_DIRECTORY,
            $fileName
        );

        $media = $company->media()->create([
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
