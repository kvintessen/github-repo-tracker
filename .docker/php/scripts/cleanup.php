<?php
// Пример задачи: удаление временных файлов старше 7 дней
$tempDir = __DIR__ . '/../tmp/';
$files = glob($tempDir . '*');

foreach ($files as $file) {
    if (is_file($file) && filemtime($file) < time() - 7 * 24 * 60 * 60) {
        unlink($file);
    }
}
echo "Cleanup completed at " . date('Y-m-d H:i:s') . PHP_EOL;
