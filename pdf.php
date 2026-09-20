<?php

/**
 * Генерація PDF: php pdf.php [template] [output.pdf]
 *
 *   php pdf.php                      — шаблон за замовчуванням у pdf/
 *   php pdf.php classic              — інший шаблон
 *   php pdf.php modern ~/CV.pdf      — свій шлях для файлу
 */

error_reporting(E_ALL & ~E_DEPRECATED);

require __DIR__ . '/vendor/autoload.php';

if (in_array($argv[1] ?? '', ['-h', '--help'], true)) {
    echo "Usage: php pdf.php [template] [output.pdf]\n\nTemplates:\n";
    foreach (\CvPdf\Template::AVAILABLE as $name => $description) {
        printf("  %-10s %s%s\n", $name, $description, $name === \CvPdf\Template::DEFAULT ? ' (default)' : '');
    }
    exit(0);
}

try {
    $file = (new \CvPdf\Pdf($argv[1] ?? null, $argv[2] ?? null))->run();
} catch (\InvalidArgumentException $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
}

echo $file . PHP_EOL;
