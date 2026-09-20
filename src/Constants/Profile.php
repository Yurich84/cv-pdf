<?php

namespace CvPdf\Constants;

class Profile
{
    const NAME = 'Yurii Tymchuk';
    const TITLE = 'Senior Laravel + Vue.js Developer, TechLead';
    const PHOTO = 'my_photo.jpg';

    const LOCATION = 'Santa Cruz de Tenerife, Canary Islands 38006, Spain';
    const EMAIL = 'Yurich84@gmail.com';
    const PHONE = '+34 613 46 46 99';

    const SUMMARY = 'Full-stack engineer and tech lead with 8 years of designing, building and evolving '
        . 'production systems on Laravel and Vue. I look at the system around a feature, not only at the '
        . 'feature: how it is structured, tested, deployed, monitored and maintained by the team. I automate '
        . 'everything that can be automated — deployments, routine engineering work, quality gates — so the '
        . 'whole team moves faster, not just me. With legacy I prefer incremental migration over rewrites: '
        . 'no code freeze, no big bang, development never stops. I work with AI the same way I work with any '
        . 'external dependency — structured output, schema validation and a controlled pipeline instead of '
        . 'trusting a model to behave. Comfortable owning a product end to end, from database design and '
        . 'architecture to CI/CD, production troubleshooting and the people doing the work.';

    /**
     * icon — символ з DejaVu Sans (BMP), решта гліфів у dompdf не рендериться.
     */
    const CONTACTS = [
        ['icon' => '☎', 'text' => self::PHONE,    'url' => 'tel:+34613464699'],
        ['icon' => '✉', 'text' => self::EMAIL,    'url' => 'mailto:Yurich84@gmail.com'],
        ['icon' => '✈', 'text' => 'Yurich84',     'url' => 'https://t.me/Yurich84'],
        ['icon' => '⌂', 'text' => 'Spain, Santa-Cruz-de-Tenerife', 'url' => null],
    ];

    const SOCIALS = [
        ['icon' => '●', 'label' => 'LinkedIn', 'text' => 'linkedin.com/in/yuriy-timchuk', 'url' => 'https://linkedin.com/in/yuriy-timchuk'],
        ['icon' => '●', 'label' => 'Web-site', 'text' => 'yurich84.github.io',            'url' => 'https://yurich84.github.io'],
        ['icon' => '●', 'label' => 'Github',   'text' => 'github.com/Yurich84',           'url' => 'https://github.com/Yurich84'],
        ['icon' => '●', 'label' => 'Dev.to',   'text' => 'dev.to/yurich84',               'url' => 'https://dev.to/yurich84'],
    ];
}
