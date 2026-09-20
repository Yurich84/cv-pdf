<?php

/**
 * Прев'ю CV у браузері: php -S localhost:8000
 * Вибір шаблону: http://localhost:8000/?template=classic
 */

error_reporting(E_ALL & ~E_DEPRECATED);

require __DIR__ . '/vendor/autoload.php';

header('Content-Type: text/html; charset=UTF-8');

try {
    echo (new \CvPdf\Html($_GET['template'] ?? null))->render();
} catch (\InvalidArgumentException $e) {
    http_response_code(404);
    echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
