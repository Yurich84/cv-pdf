<?php

/**
 * Генерація PDF: php pdf.php [template] [--data=version] [output.pdf]
 *
 *   php pdf.php                          — шаблон і версія за замовчуванням, у pdf/
 *   php pdf.php modern                   — інший шаблон
 *   php pdf.php --data=short             — інша версія даних
 *   php pdf.php ~/CV.pdf                 — свій шлях для файлу
 *   php pdf.php modern --data=short ~/CV.pdf
 *
 * Аргументи розпізнаються за виглядом, а не за позицією: *.pdf — це шлях,
 * решта — шаблон. Версія йде прапорцем, бо на слух не відрізняється
 * від імені шаблону.
 */

error_reporting(E_ALL & ~E_DEPRECATED);

require __DIR__ . '/vendor/autoload.php';

$version = null;
$output = null;
$positional = [];

foreach (array_slice($argv, 1) as $arg) {
    if (in_array($arg, ['-h', '--help'], true)) {
        echo "Usage: php pdf.php [template] [--data=version] [output.pdf]\n\nTemplates:\n";
        foreach (\CvPdf\Template::AVAILABLE as $name => $description) {
            printf("  %-10s %s%s\n", $name, $description, $name === \CvPdf\Template::DEFAULT ? ' (default)' : '');
        }
        echo "\nData versions (data/*.json):\n";
        foreach (\CvPdf\Cv::available() as $name => $label) {
            printf("  %-10s %s%s\n", $name, $label, $name === \CvPdf\Cv::DEFAULT ? ' (default)' : '');
        }
        exit(0);
    }

    if (str_starts_with($arg, '--data=')) {
        $version = substr($arg, strlen('--data='));
        continue;
    }

    // Шлях розпізнаємо за розширенням, а не за позицією: так `php pdf.php ~/CV.pdf`
    // і `php pdf.php modern ~/CV.pdf` обидва працюють без зайвих прапорців.
    if (str_ends_with(strtolower($arg), '.pdf')) {
        $output = $arg;
        continue;
    }

    $positional[] = $arg;
}

try {
    $file = (new \CvPdf\Pdf($positional[0] ?? null, $version, $output))->run();
} catch (\InvalidArgumentException $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
}

echo $file . PHP_EOL;
