<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$settings = DB::table('settings')->pluck('value', 'key');

echo "Current Settings in Database:\n";
echo "site_default_color: " . ($settings['site_default_color'] ?? 'NOT SET') . "\n";
echo "site_btn_color: " . ($settings['site_btn_color'] ?? 'NOT SET') . "\n";
echo "site_gradient_color: " . ($settings['site_gradient_color'] ?? 'NOT SET') . "\n";
