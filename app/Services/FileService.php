<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\UploadedFile;

class FileService
{
    public function uploadAvatar(UploadedFile $file, $userId): array
    {
        $fileName = $this->generateFileName($file);
        $path = $this->getUserAvatarPath($userId);

        Storage::disk("public")->put($path . '/' . $fileName, file_get_contents($file), 'public');

        return [
            'name' => $fileName,
            'mimetype' => $file->getClientMimeType(),
            'type' => 'user_avatars',
            'size' => $file->getSize(),
        ];
    }

    public function uploadAnimeThumbnail(UploadedFile $file, $animeID): array
    {
        $fileName = $this->generateFileName($file);
        $path = $this->getAnimeThumbnailPath($animeID);

        Storage::disk("public")->put($path . '/' . $fileName, file_get_contents($file), 'public');

        return [
            'name' => $fileName,
            'mimetype' => $file->getClientMimeType(),
            'type' => 'anime_thumbnails',
            'size' => $file->getSize(),
        ];
    }

    public function uploadBlogThumbnail(UploadedFile $file, $id): array
    {
        $fileName = $this->generateFileName($file);
        $path = $this->getBlogThumbnailPath($id);

        Storage::disk("public")->put($path . '/' . $fileName, file_get_contents($file), 'public');

        return [
            'name' => $fileName,
            'mimetype' => $file->getClientMimeType(),
            'type' => 'blog_thumbnails',
            'size' => $file->getSize(),
        ];
    }

    private function generateFileName(UploadedFile $file): string
    {
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        return Str::slug($name) . '.' . $extension;
    }

    private function getUserAvatarPath($userId): string
    {
        return 'user_avatars/' . md5($userId);
    }

    private function getAnimeThumbnailPath($animeId): string
    {
        return 'anime_thumbnails/' . md5($animeId);
    }

    private function getBlogThumbnailPath($blogId): string
    {
        return 'blog_thumbnails/' . md5($blogId);
    }
}
