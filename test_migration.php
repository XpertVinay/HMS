<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

config(['database.default' => 'sqlite']);
config(['database.connections.sqlite' => [
    'driver' => 'sqlite',
    'database' => ':memory:',
    'prefix' => '',
]]);

try {
    Artisan::call('migrate:fresh');
    echo Artisan::output();
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
