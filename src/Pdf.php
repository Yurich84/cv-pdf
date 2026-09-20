<?php

namespace CvPdf;

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    /** Ліва смуга шаблону modern: ширина, висота A4 і колір у частках. */
    private const RAIL_WIDTH = 190.0;
    private const RAIL_HEIGHT = 842.0;
    private const RAIL_COLOR = [0.855, 0.898, 0.961];

    private Dompdf $dompdf;
    private Html $html;
    private string $template;
    private string $version;
    private string $fileName;

    public function __construct(?string $template = null, ?string $version = null, ?string $fileName = null)
    {
        $this->html = new Html($template, $version);
        $this->template = $this->html->template();
        $this->version = $this->html->version();

        $this->dompdf = $this->makeDompdf();

        $this->fileName = $fileName ?: sprintf(
            '%s/pdf/CV_%s_%s%s.pdf',
            dirname(__DIR__),
            $this->template,
            // Версію в імені згадуємо, тільки якщо вона не типова:
            // інакше кожен файл тягне зайве «_default».
            $this->version === Cv::DEFAULT ? '' : $this->version . '_',
            date('d.m.y_His')
        );
    }

    private function makeDompdf(): Dompdf
    {
        $options = new Options();
        $options->setChroot(__DIR__);
        $options->setIsRemoteEnabled(false);
        $options->setDefaultFont('DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4');

        return $dompdf;
    }

    public function run(): string
    {
        $this->render();
        $this->save();

        return $this->fileName;
    }

    private function render(): void
    {
        $this->dompdf->loadHtml($this->html->render());
        $this->dompdf->render();

        if ($this->template === 'modern') {
            $this->paintRail($this->resumePageCount());
        }
    }

    /**
     * Скільки сторінок займає резюме без портфоліо. Вміст до портфоліо
     * в обох рендерах однаковий, тому і розбиття на сторінки однакове.
     */
    private function resumePageCount(): int
    {
        $probe = $this->makeDompdf();
        $probe->loadHtml($this->html->render(false));
        $probe->render();

        return $probe->getCanvas()->get_page_count();
    }

    /**
     * Домальовує ліву смугу на сторінках резюме з другої по $lastPage.
     * Першу сторінку малює сам сайдбар, портфоліо смуги не отримує.
     *
     * Викликати тільки після render(): page_script у dompdf не відкладає
     * колбек, а одразу проходить уже створеними сторінками.
     */
    private function paintRail(int $lastPage): void
    {
        if ($lastPage < 2) {
            return;
        }

        $this->dompdf->getCanvas()->page_script(
            function ($pageNumber, $pageCount, $canvas) use ($lastPage) {
                if ($pageNumber < 2 || $pageNumber > $lastPage) {
                    return;
                }

                $canvas->filled_rectangle(0, 0, self::RAIL_WIDTH, self::RAIL_HEIGHT, self::RAIL_COLOR);
            }
        );
    }

    private function save(): void
    {
        $dir = dirname($this->fileName);

        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents($this->fileName, $this->dompdf->output());
    }
}
