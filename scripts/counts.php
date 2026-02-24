<?php

$vendor = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($vendor)) {
	echo "vendor/autoload.php not found. Run composer install first." . PHP_EOL;
	exit(1);
}

require $vendor;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'Books: ' . App\Models\Book::count() . PHP_EOL;
echo 'Photos: ' . App\Models\Photo::count() . PHP_EOL;
