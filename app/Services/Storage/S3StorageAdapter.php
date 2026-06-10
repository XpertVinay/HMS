<?php

namespace App\Services\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class S3StorageAdapter implements StorageAdapterInterface
{
    public function upload(UploadedFile $file, string $path): string
    {
        return $file->store($path, 's3');
    }

    public function getUrl(string $path): string
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // For logos/public images, we might want public URL. 
        // For profiles/galleries, we might want temporary URL.
        // Assuming we return temporary URL for all paths for security, valid for 1 hour.
        try {
            return Storage::disk('s3')->temporaryUrl($path, now()->addHour());
        } catch (\Exception $e) {
            return Storage::disk('s3')->url($path);
        }
    }
}
