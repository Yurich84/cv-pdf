<?php

namespace CvPdf;

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    private Dompdf $dompdf;
    private string $file_name;

    
    public function __construct()
    {
        $options = new Options();
        $options->setChroot(__DIR__);
        
        $this->dompdf = new Dompdf($options);
        $this->dompdf->setPaper('A4');
    
        $this->file_name = dirname(__DIR__) . '/pdf/CV_' . date('d.m.y') . '.pdf';
    }
    
    private function render()
    {
        $html = (new Html())->render();
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();
    }
    
    private function save()
    {
        file_put_contents($this->file_name, $this->dompdf->output());
    }
    
    private function copy()
    {
        exec('cp ' . $this->file_name . ' ~/Desktop/FOP/PDF');
    }
    
    public function run()
    {
        $this->render();
        $this->save();
//        $this->copy();
    
        exit(0);
    }
}
