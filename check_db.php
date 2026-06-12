<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$roles = \Spatie\Permission\Models\Role::count();
$permissions = \Spatie\Permission\Models\Permission::count();
$users = \App\Models\User::count();

echo "Roles: $roles\n";
echo "Permissions: $permissions\n";
echo "Users: $users\n";
