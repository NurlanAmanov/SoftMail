<?php
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

// Serverin bu skripti yarıda kəsməməsi üçün vaxt limitini ləğv edirik
set_time_limit(0); 
ignore_user_abort(true);

define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "<h1>Bütün maillər göndərilir, bitənə qədər pəncərəni bağlamayın...</h1>";

try {
    // --max-jobs limitini sildik, bazada nə varsa hamısını bitirənə qədər işləyəcək
    Artisan::call('queue:work', [
        '--stop-when-empty' => true, // Bazada mail bitəndə dayanacaq
        '--timeout' => 0,            // Zaman aşımı olmasın
    ]);
    
    echo "<pre>" . Artisan::output() . "</pre>";
    echo "Uğurlu: Bütün növbə təmizləndi!";
} catch (\Exception $e) {
    echo "Xəta: " . $e->getMessage();
}