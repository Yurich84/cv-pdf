<?php

namespace CvPdf;

class Experience
{
    public function __invoke()
    {
        return [
            'role' => 'web developer',
            'company' => 'Niru',
            'from' => '2013',
            'to' => '2018',
            'description' => '
            Involved in the full cycle of web application development:
            - Discussion and thinking through business logic -> technology selection -> application and database architecture -> backend development -> layout and frontend development -> search engine optimization -> support.
            - During this work, i’ve created dozens web applications and integrated various APIs',
        ];
    }
}
