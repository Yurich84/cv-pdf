<?php

namespace CvPdf;

use CvPdf\Constants\Education;
use CvPdf\Constants\Experience;
use CvPdf\Constants\Language;
use CvPdf\Constants\Portfolio;
use CvPdf\Constants\Profile;
use CvPdf\Constants\Skill;
use Jenssegers\Blade\Blade;

class Html
{
    private Blade $blade;
    private string $template;

    public function __construct(?string $template = null)
    {
        $this->template = Template::resolve($template);

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
        return $this->blade->render('index', [
            'css' => $this->css(),
            'profile' => Profile::class,
            'photo' => $this->image(Profile::PHOTO),
            'summary' => Profile::SUMMARY,
            'contacts' => Profile::CONTACTS,
            'socials' => Profile::SOCIALS,
            'experience' => Experience::VALUES,
            'education' => Education::VALUES,
            'languages' => Language::VALUES,
            'portfolio' => $withPortfolio ? $this->portfolio() : [],
            'skills_top' => Skill::TOP,
            'skills_groups' => Skill::GROUPS,
            'skills_flat' => Skill::flat(),
            'skill' => Skill::class,
            'skills_familiar' => Skill::FAMILIAR,
        ]);
    }

    public function template(): string
    {
        return $this->template;
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

    private function portfolio(): array
    {
        return array_map(function (array $project) {
            $project['image'] = $this->image($project['image']);

            return $project;
        }, Portfolio::VALUES);
    }
}
