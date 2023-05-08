<?php

namespace CvPdf;

use CvPdf\Constants\Education;
use CvPdf\Constants\Experience;
use CvPdf\Constants\Language;
use CvPdf\Constants\Skill;
use Jenssegers\Blade\Blade;

class Html
{
    private Blade $blade;
    
    public function __construct()
    {
        $this->blade = new Blade(__DIR__ . '/view', __DIR__ . '/view/cache');
    }
    
    public function render()
    {
        return $this->blade->render('index', [
            'experience' => Experience::VALUES,
            'education' => Education::VALUES,
            'languages' => Language::VALUES,
            'skills_top' => Skill::TOP,
            'skills_main' => Skill::MAIN,
            'skills_familiar' => Skill::FAMILIAR,
        ]);
    }
    
}
