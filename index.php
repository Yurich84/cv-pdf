<?php

/**
 * Прев'ю CV у браузері: php -S localhost:8000
 *
 *   ?template=modern   — інший шаблон (за замовчуванням classic)
 *   ?data=short        — інша версія даних з data/*.json
 */

error_reporting(E_ALL & ~E_DEPRECATED);

require __DIR__ . '/vendor/autoload.php';

header('Content-Type: text/html; charset=UTF-8');

try {
    echo (new \CvPdf\Html($_GET['template'] ?? null, $_GET['data'] ?? null))->render();
} catch (\InvalidArgumentException $e) {
    http_response_code(404);
    echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
