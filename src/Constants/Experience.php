<?php

namespace CvPdf\Constants;

class Experience
{
    const VALUES = [
        [
            'role' => 'Technical lead',
            'company' => 'CheItGroup',
            'location' => 'Remote',
            'from' => 'Mar 2024',
            'to' => 'Present',
            'items' => [
                'Own the key technical decisions and the architecture direction, and align the team around common goals',
                'Own the delivery pipeline for five interdependent applications: sandbox environments are fully automated, staging and production are deployed by a single command followed by a verification step',
                'Responsible for release strategy and production health — rollout, rollback, bottlenecks between Nginx, PHP-FPM, Laravel, queues and external services',
                'Run the AI infrastructure of the platform: self-hosted models behind vLLM and LiteLLM, document processing and OCR pipelines, structured output with schema validation',
                'Own search and matching: hybrid exact and vector search in Elasticsearch, with ranking scores validated against real process outcomes',
                'Define engineering standards — linters, code style, review rules, agents and workflows — which lets AI take over a large share of routine work and speeds it up 3–4 times',
                'Own the QA strategy: test coverage matrix for business-critical flows, separation of unit tests and automation, prioritisation over raw test count',
                'Drive the gradual Vue 2 to Vue 3 migration with the Strangler Fig approach, without a rewrite and without a code freeze',
                'Mentor the team, improve workflows and processes, and facilitate meetings that end with decisions',
            ],
        ],
        [
            'role' => 'Full-stack engineer',
            'company' => 'Interactivated Solutions',
            'location' => 'Remote',
            'from' => 'Feb 2022',
            'to' => 'Mar 2024',
            'items' => [
                'Developed and maintained a CRM for healthcare providers covering caregiver services, invoicing, claims and payment processes',
                'Responsible for the Accounts Receivable domain, including a dashboard that gave the company control over its financial flow',
                'Implemented data exchange between healthcare providers and insurance companies using the 837 and 835 file formats',
                'Owned the engineering setup of the project: CI/CD, git-flow, testing, code style and security',
                'Integrated and supported external services — Mailgun, MS Graph — together with queued jobs and scheduled tasks',
                'Worked with the team on a new claims system and on the interaction between clients, caregivers and companies',
            ],
        ],
        [
            'role' => 'Backend developer',
            'company' => 'CheItGroup',
            'location' => 'Chernihiv',
            'from' => 'Apr 2020',
            'to' => 'Jan 2022',
            'items' => [
                'Responsible for a separate service of the Rocken CRM ecosystem that gave candidates and companies access to their own profiles, built on a microservice architecture in Docker on DigitalOcean; Rocken is now among the top 3 job search sites in Switzerland',
                'Designed the database and application architecture, backend and frontend',
                'Set up CI/CD with zero-downtime deployment and introduced GitFlow as the team workflow',
                'Gathered and interviewed the team, mentored developers and consulted on technical decisions',
                "Delivered a standalone CRM for a network of Porsche showrooms in Switzerland — from the owner's idea to structure, UX and release",
                'Contributed to open source',
            ],
        ],
        [
            'role' => 'Full-stack developer',
            'company' => 'Skyup studio',
            'location' => 'Remote',
            'from' => 'Aug 2019',
            'to' => 'Apr 2020',
            'summary' => 'Developed a large CRM and a PWA. Delivered an SPA built around third-party APIs, '
                . 'and was responsible for its frontend architecture while working closely with the team.',
            'items' => [],
        ],
        [
            'role' => 'Freelance web developer',
            'company' => '',
            'location' => 'Remote',
            'from' => 'Apr 2013',
            'to' => 'Jul 2019',
            'items' => [
                'Built and supported online stores on various CMS and PHP frameworks, from small catalogues to shops with thousands of products',
                'Responsible for the full cycle of each project: requirements, data structure, backend, frontend, deployment and further support',
                'Integrated payment providers, delivery services, and import and export of product data',
                'Worked directly with business owners, translated their ideas into requirements and advised on technical options',
                'Maintained and refactored inherited codebases, and migrated legacy projects to newer platforms',
            ],
        ],
    ];
}
