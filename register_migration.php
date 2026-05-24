<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Kernel::class)->bootstrap();

// Get all migration files
$migrationsDir = __DIR__.'/database/migrations';
$files = scandir($migrationsDir);
$migrationFiles = array_filter($files, function ($f) {
    return strpos($f, '.php') !== false;
});

$registered = 0;
foreach ($migrationFiles as $file) {
    $filename = str_replace('.php', '', $file);

    if (! DB::table('migrations')->where('migration', $filename)->exists()) {
        DB::table('migrations')->insert([
            'migration' => $filename,
            'batch' => 1,
        ]);
        echo "Recorded: $filename\n";
        $registered++;
    }
}

echo "\nTotal migrations registered: $registered\n";
