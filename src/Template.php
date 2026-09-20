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
    const DEFAULT = 'classic';

    const AVAILABLE = [
        'classic' => 'Одна колонка на дві сторінки, ATS-friendly — під автоматичний парсинг вакансій',
        'modern' => 'Дві колонки, фото, темна шапка, портфоліо з картинками',
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
