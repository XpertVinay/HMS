<?php

namespace App\Console\Commands;

use App\Services\FirebaseCredentialsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportFirebaseCredentials extends Command
{
    protected $signature = 'firebase:import-credentials
                            {file? : Path to the Firebase service account JSON file}
                            {--project=app : Firebase project key in config/firebase.php}';

    protected $description = 'Import Firebase service account JSON into the database';

    public function handle(FirebaseCredentialsService $credentialsService): int
    {
        $file = $this->argument('file') ?? storage_path('app/firebase-credentials.json');

        if (!File::exists($file)) {
            $this->error("Credentials file not found: {$file}");

            return self::FAILURE;
        }

        $contents = File::get($file);
        $credentials = json_decode($contents, true);

        if (!is_array($credentials) || json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON in credentials file.');

            return self::FAILURE;
        }

        $projectKey = (string) $this->option('project');
        $credentialsService->store($credentials, $projectKey);

        $this->info("Firebase credentials imported for project [{$projectKey}].");
        $this->line('Credentials are now loaded from the database — no local file is required at runtime.');

        return self::SUCCESS;
    }
}
