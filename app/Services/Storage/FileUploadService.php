<?php

namespace App\Services\Storage;

use Illuminate\Http\UploadedFile;

class FileUploadService
{
    protected StorageAdapterInterface $adapter;

    public function __construct()
    {
        // Read feature flag/configuration
        // 'local', 's3', 'firebase'
        $driver = config('filesystems.default', 'local');

        switch ($driver) {
            case 's3':
                $this->adapter = new S3StorageAdapter();
                break;
            case 'firebase':
                $this->adapter = new FirebaseStorageAdapter();
                break;
            case 'local':
            default:
                $this->adapter = new LocalStorageAdapter();
                break;
        }
    }

    public function upload(UploadedFile $file, string $path): string
    {
        return $this->adapter->upload($file, $path);
    }

    public function getUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }
        
        return $this->adapter->getUrl($path);
    }
}
