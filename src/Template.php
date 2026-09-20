<?php

namespace CvPdf;

/**
 * Реєстр доступних шаблонів CV.
 *
 * Кожен шаблон — це тека src/view/templates/<name> з файлами
 * index.blade.php та styles.css. Ім'я шаблону приходить ззовні
 * (CLI-аргумент або query-параметр), тому воно завжди звіряється
 * зі списком нижче й ніколи не потрапляє у файловий шлях напряму.
 */
class Template
{
    const DEFAULT = 'modern';

    const AVAILABLE = [
        'modern' => 'Дві колонки, фото, темна шапка — як у друкованому CV',
        'classic' => 'Одна колонка, ATS-friendly — під автоматичний парсинг вакансій',
    ];

    public static function resolve(?string $name): string
    {
        $name = trim((string) $name);

        if ($name === '') {
            return self::DEFAULT;
        }

        if (! isset(self::AVAILABLE[$name])) {
            throw new \InvalidArgumentException(sprintf(
                'Невідомий шаблон "%s". Доступні: %s',
                $name,
                implode(', ', array_keys(self::AVAILABLE))
            ));
        }

        return $name;
    }

    public static function viewPath(string $name): string
    {
        return __DIR__ . '/view/templates/' . $name;
    }

    public static function stylesPath(string $name): string
    {
        return self::viewPath($name) . '/styles.css';
    }
}
