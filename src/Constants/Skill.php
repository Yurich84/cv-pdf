<?php

namespace CvPdf\Constants;

class Skill
{
    /** Головний стек — виноситься окремим блоком угорі. */
    const TOP = [
        'Laravel - 8 Years',
        'Vue.js - 5 Years',
        'RDBMS - 10 Years',
    ];

    /** Згруповані навички: шаблон або показує групи, або плоский список. */
    const GROUPS = [
        'Backend' => [
            'Laravel', 'PHP', 'Yii2', 'Symfony', 'SOLID',
        ],
        'Frontend' => [
            'Vue 3', 'Nuxt', 'Vuex', 'Pinia', 'Composition API', 'React',
            'JavaScript', 'Tailwind', 'SASS', 'Webpack', 'Vite',
        ],
        'AI' => [
            'AI integration', 'LLM', 'Claude', 'Codex',
        ],
        'Infrastructure' => [
            'Docker', 'Docker Swarm', 'Nginx', 'GitLab CI/CD', 'Git',
        ],
        'Data' => [
            'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Elasticsearch',
        ],
    ];

    const FAMILIAR = [
        'Node.js',
        'Python',
    ];

    /** Плоский список усіх навичок — для шаблонів без групування. */
    public static function flat(): array
    {
        return array_merge(...array_values(self::GROUPS));
    }

    /**
     * Розкладає плоский список по $columns колонках (для табличних шаблонів).
     *
     * Кількість колонок — побажання, а не гарантія: колонки виходять рівними,
     * тому остання може бути неповною, а при малій кількості навичок їх може
     * вийти менше, ніж замовлено. Шаблон має це витримувати.
     */
    public static function columns(int $columns): array
    {
        $all = self::flat();

        return array_chunk($all, (int) ceil(count($all) / $columns));
    }
}
