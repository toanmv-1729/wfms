<?php

namespace App\Services;

use DB;
use App\Models\User;
use App\Models\Media;
use App\Helpers\ContentsHelper;
use App\Contracts\Repositories\UserRepository;
use Illuminate\Contracts\Debug\ExceptionHandler;

class UserService
{
    const IMAGE_DIRECTORY = 'image/avatars/';

    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function updateProfile(User $user, $data)
    {
        DB::beginTransaction();
        $user->update([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
            'phone' => $data['phone'] ?? $user->phone,
            'address' => $data['address'] ?? $user->address,
        ]);
        try {
            if (isset($data['avatar'])){
                $this->uploadAvatar($user, $data['avatar']);
            }
            DB::commit();
        } catch (Exception $exception) {
            app(ExceptionHandler::class)->report($exception);
            DB::rollBack();
            return false;
        }

        return true;
    }

    /**
     * @param User $user
     * @param \Illuminate\Http\UploadedFile $backgroundImage
     * @return null|mixed
     */
    public function uploadAvatar($user, $backgroundImage)
    {
        $user->media()->delete();
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
