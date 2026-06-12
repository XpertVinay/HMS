<?php

namespace App\Services\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FirebaseStorageAdapter implements StorageAdapterInterface
{
    public function upload(UploadedFile $file, string $path): string
    {
        // Assuming a firebase disk is configured
        return $file->store($path, 'firebase');
    }

    public function getUrl(string $path): string
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return Storage::disk('firebase')->url($path);
    }
}
