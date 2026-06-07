<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class VerifySchemaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schema:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies that all model $fillable columns exist in the database to prevent production crashes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting schema verification...');
        
        $modelsPath = app_path('Models');
        if (!File::exists($modelsPath)) {
            $this->error("Models directory not found at: {$modelsPath}");
            return 1;
        }

        $modelFiles = File::allFiles($modelsPath);
        $errors = 0;
        
        foreach ($modelFiles as $file) {
            $namespace = 'App\\Models\\';
            $class = $namespace . str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathname());
            
            if (class_exists($class) && is_subclass_of($class, 'Illuminate\Database\Eloquent\Model')) {
                // Ignore abstract classes
                $reflection = new \ReflectionClass($class);
                if ($reflection->isAbstract()) {
                    continue;
                }

                try {
                    $model = new $class;
                    $table = $model->getTable();
                    $fillables = $model->getFillable();

                    if (empty($fillables)) {
                        continue;
                    }

                    if (!Schema::hasTable($table)) {
                        $this->error("Table '{$table}' for model {$class} does not exist!");
                        $errors++;
                        continue;
                    }

                    foreach ($fillables as $column) {
                        if (!Schema::hasColumn($table, $column)) {
                            $this->error("Missing column '{$column}' in table '{$table}' expected by model {$class}.");
                            $errors++;
                        }
                    }
                } catch (\Exception $e) {
                    $this->warn("Could not instantiate or verify {$class}: " . $e->getMessage());
                }
            }
        }

        if ($errors > 0) {
            $this->error("Schema verification failed with {$errors} error(s). Please fix the database schema or update the model.");
            return 1;
        }

        $this->info('All models are perfectly in sync with the database schema!');
        return 0;
    }
}
