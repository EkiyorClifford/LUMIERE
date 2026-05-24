<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\View\Compilers\BladeCompiler;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();
$blade = $app->make(BladeCompiler::class);
$path = __DIR__.'/resources/views/admin/admin-login.blade.php';
$content = file_get_contents($path);
echo $blade->compileString($content);
