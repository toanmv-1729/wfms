<?php

namespace App\Helpers;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\UploadedFile;

class ContentsHelper
{
    private static $mediaInfo = [];

    /**
     * Add Media Info
     *
     * @param $filePath
     * @param $source
     * @param $type
     */
    public static function addMediaInfo($filePath, $source, $type)
    {
        if ($source instanceof UploadedFile) {
            $imageSize = getimagesize($source);
            $baseSize['width'] = $imageSize[0];
            $baseSize['height'] = $imageSize[1];

            $fileName = $source->getClientOriginalName();
            $filExtension = substr($fileName, strrpos($fileName, '.') + 1);

            self::$mediaInfo[$filePath] = [
                'name' => $fileName,
                'path' => $filePath,
                'extension' => $filExtension ?? $source->extension() ?? $source->getClientOriginalExtension(),
                'size' => $source->getSize(),
                'type' => $type,
                'mime_type' => $source->getMimeType(),
                'width' => $baseSize['width'],
                'height' => $baseSize['height'],
            ];

            return;
        }

        if ($source instanceof \Intervention\Image\Image) {
            self::$mediaInfo[$filePath] = [
                'name' => $source->basename,
                'path' => $filePath,
                'extension' => $source->extension,
                'size' => $source->filesize(),
                'type' => $type,
                'mime_type' => $source->mime,
                'width' => $source->width(),
                'height' => $source->height(),
            ];
        }
    }

    /**
     * Get Media Info
     *
     * @param $filePath
     * @return array | boolean
     */
    public static function getMediaInfo($filePath)
    {
        return isset(self::$mediaInfo[$filePath]) ? self::$mediaInfo[$filePath] : false;
    }

    /**
     * Store Image
     *
     * @param $source
     * @param String $folderPath relative path from "public". end with / (ex. "./images/" )
     * @param String $imageName fileName
     * @param integer $maxSize
     * @return String
     */
    public static function storeImage($source, $folderPath, $imageName, $maxSize = 1024)
    {
        $img = Image::make($source);
        $imgHeight = $img->height();
        $imgWidth = $img->width();

        if ($imgHeight >= $imgWidth) {
            if ($imgHeight >= $maxSize) {
                $img->resize(null, $maxSize, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        } else {
            if ($imgWidth >= $maxSize) {
                $img->resize($maxSize, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }

        $stream = $img->stream();
        $filePath = $folderPath . $imageName;

        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }

        Storage::put($filePath, (string) $stream);

        self::addMediaInfo($filePath, $source, Media::TYPE_IMAGE);

        return $filePath;
    }

    /**
     * Store Image With Preview
     *
     * @param \Illuminate\Filesystem\Filesystem $source
     * @param String $folderPath relative path from "public". end with / (ex. "./images/" )
     * @param String $imageName fileName
     * @return array {originalContentUrl, previewImageUrl}
     */
    public static function storeImageWithPreview($source, $folderPath, $imageName, $maxSize = 1024)
    {
        $originalContentUrl = self::storeOriginalImage($source, $folderPath, $imageName);
        // $originalContentUrl = self::storeImage($source, $folderPath, $imageName, $maxSize);
        $previewImageUrl = self::storeImage($source, $folderPath, 'preview_' . $imageName, 240);

        return [
            'originalContentUrl' => $originalContentUrl,
            'previewImageUrl' => $previewImageUrl,
        ];
    }

    /**
     * Store Video
     *
     * @param $file
     * @param string $folderPath
     * @param string $videoName
     * @param bool $isReply
     * @return string
     */
    public static function storeVideo($file, $folderPath, $videoName, $isReply = false)
    {
        // TODO: varidation
        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }

        $filePath = $folderPath . $videoName;

        if ($isReply == true) {
            Storage::put($filePath, $file);
        } else {
            Storage::putFileAs($folderPath, $file, $videoName);
        }

        self::addMediaInfo($filePath, $file, Media::TYPE_VIDEO);

        return $filePath;
    }

    /**
     * Store Video With Preview
     *
     * @param \Illuminate\Filesystem\Filesystem $file
     * @param String $folderPath relative path from "public". end with / (ex. "./images/" )
     * @param String $imageName fileName
     * @param boolean $isReply
     * @return array {originalContentUrl, previewImageUrl}
     */
    public static function storeVideoWithPreview($file, $folderPath, $imageName, $isReply = false)
    {
        $originalContentUrl = self::storeVideo($file, $folderPath, $imageName, $isReply);
        $previewImageUrl = static::getThumbImageOfVideo($file, $folderPath, $imageName);

        return [
            'originalContentUrl' => $originalContentUrl,
            'previewImageUrl' => $previewImageUrl,
        ];
    }

    /**
     * @param mixed $prefix
     * @return String unique name for a content
     */
    public static function getUniqueContentName($prefix = null)
    {
        $prefix = uuid_str(str_slug($prefix));

        return date('Ymdhis', time()) . '-' . $prefix;
    }

    public static function storeFile($file, $folderPath, $fileName)
    {
        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }

        Storage::putFileAs($folderPath, $file, $fileName);
        $filePath = $folderPath . $fileName;
        self::addMediaInfo($filePath, $file, Media::TYPE_FILE);

        return $filePath;
    }

    /**
     * Get path of thumb image url
     *
     * @param $file
     * @param $folderPath
     * @param $imageName
     * @return string
     */
    public static function getThumbImageOfVideo($file, $folderPath, $imageName)
    {
        try {
            if ($file instanceof UploadedFile) {
                $file = $file->getPathname();
            }

            $tmpImageFilePath = storage_path('video_thumb' . $imageName . '_' . time() . '.jpg');
            $execCommand = 'ffmpeg -i ' . $file . ' -ss 00:00:01.000 -vframes 1 ' . $tmpImageFilePath;

            exec($execCommand);

            $previewImageUrl = self::storeImage(
                $tmpImageFilePath,
                $folderPath,
                'preview_' . $imageName,
                240
            );

            // remove tmp file
            if (file_exists($tmpImageFilePath)) {
                unlink($tmpImageFilePath);
            }

            return $previewImageUrl;
        } catch (\Exception $e) {
            report($e);
            // return default hr-prime logo in case server cannot use ffmpeg to get frame of video
            return asset(config('common.hr_prime_logo'));
        }
    }

    /**
     * Store original image without resize
     * @param string $source
     * @param string $folderPath
     * @param string $imageName
     * @return string
     */
    private static function storeOriginalImage($source, $folderPath, $imageName)
    {
        if ($source instanceof UploadedFile) {
            $stream = file_get_contents($source);
        } else {
            $img = Image::make($source);
            $stream = $img->stream();
        }
        $filePath = $folderPath . $imageName;

        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }

        Storage::put($filePath, $stream);

        self::addMediaInfo($filePath, $source, Media::TYPE_IMAGE);

        return $filePath;
    }
}
