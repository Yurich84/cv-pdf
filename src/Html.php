<?php

namespace CvPdf;

use Jenssegers\Blade\Blade;

class Html
{
    private Blade $blade;
    private string $template;
    private Cv $cv;

    public function __construct(?string $template = null, ?string $version = null)
    {
        $this->template = Template::resolve($template);
        $this->cv = Cv::load($version);

        $cache = __DIR__ . '/view/cache';

        if (! is_dir($cache)) {
            mkdir($cache, 0775, true);
        }

        $this->blade = new Blade(Template::viewPath($this->template), $cache);
    }

    /**
     * @param bool $withPortfolio false рендерить резюме без портфоліо —
     *                            Pdf.php так рахує, скільки сторінок займає
     *                            саме резюме.
     */
    public function render(bool $withPortfolio = true): string
    {
        $profile = $this->cv->profile();

        return $this->blade->render('index', [
            'css' => $this->css(),
            'profile' => $profile,
            'photo' => $this->image($profile['photo']),
            'summary' => $profile['summary'],
            'contacts' => $this->withIcons($this->cv->contacts()),
            'socials' => $this->withIcons($this->cv->socials()),
            'experience' => $this->cv->experience(),
            'education' => $this->cv->education(),
            'languages' => $this->cv->languages(),
            'portfolio' => $withPortfolio ? $this->portfolio() : [],
            'skills' => $this->cv->skills(),
        ]);
    }

    public function template(): string
    {
        return $this->template;
    }

    public function version(): string
    {
        return $this->cv->version();
    }

    /**
     * CSS вшивається в <style>, бо відносний <link> резолвиться
     * по-різному в браузері й у dompdf.
     */
    private function css(): string
    {
        return file_get_contents(Template::stylesPath($this->template));
    }

    /**
     * Зображення віддаються як data URI — єдиний формат, який однаково
     * працює і в браузері, і в dompdf (без залежності від cwd і chroot).
     */
    private function image(string $relativePath): string
    {
        if ($relativePath === '') {
            return '';
        }

        $path = __DIR__ . '/resources/img/' . $relativePath;

        if (! is_file($path)) {
            return '';
        }

        $mime = match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'png' => 'image/png',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            default => 'image/jpeg',
        };

        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
    }

    /**
     * Додає iconImage — data URI іконки, якщо icon названо ім'ям файлу
     * з img/icons. Інакше iconImage порожній і шаблон виводить icon як
     * текстовий гліф. Ім'я звіряється з патерном, бо потрапляє у шлях.
     *
     * Іконки — PNG, а не SVG: на PHP 8.5 getimagesize() віддає розміри
     * SVG без типу, і dompdf 2.0 такий файл відкидає як битий.
     */
    private function withIcons(array $lines): array
    {
        return array_map(function (array $line) {
            $line['iconImage'] = preg_match('/^[a-z0-9-]+$/', $line['icon'])
                ? $this->image('icons/' . $line['icon'] . '.png')
                : '';

            return $line;
        }, $lines);
    }

    private function portfolio(): array
    {
        return array_map(function (array $project) {
            $project['image'] = $this->image($project['image']);

            return $project;
        }, $this->cv->portfolio());
    }
}
