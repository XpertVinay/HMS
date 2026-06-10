<?php

namespace App\Services\Storage;

use Illuminate\Http\UploadedFile;

interface StorageAdapterInterface
{
    /**
     * Upload a file and return its storage path or identifier.
     *
     * @param UploadedFile $file
     * @param string $path
     * @return string
     */
    public function upload(UploadedFile $file, string $path): string;

    /**
     * Get the publicly accessible URL for a given path.
     *
     * @param string $path
     * @return string
     */
    public function getUrl(string $path): string;
}
