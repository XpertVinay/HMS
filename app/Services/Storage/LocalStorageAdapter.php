<?php

namespace App\Services\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalStorageAdapter implements StorageAdapterInterface
{
    public function upload(UploadedFile $file, string $path): string
    {
        return $file->store($path, 'public');
    }

    public function getUrl(string $path): string
    {
        // If it's already a full URL, return it
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
