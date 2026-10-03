<?php

namespace CvPdf;

/**
 * Дані одного CV, прочитані з data/<version>.json.
 *
 * Версія — це повний набір даних: під різні вакансії зручно тримати різні
 * файли (коротший summary, інший порядок досвіду, портфоліо без частини
 * проєктів) і перемикатися між ними, не чіпаючи ні шаблони, ні код.
 *
 * Список версій збирається з теки data/, а не з константи, щоб нову версію
 * можна було додати одним `cp`. Тому ім'я, що приходить ззовні (CLI-аргумент
 * або query-параметр), ніколи не підставляється у шлях напряму: спершу воно
 * має знайтися серед імен реальних файлів.
 *
 * Портфоліо лежить окремо, у data/shared/portfolio.json, і спільне для всіх
 * версій: проєкти не підлаштовуються під вакансію, змінюється лише резюме.
 * Версії — це файли верхнього рівня, тому підтека shared/ у glob не потрапляє.
 *
 * Значення за замовчуванням проставляються тут, а не в шаблонах: шаблони
 * читають ключі без перевірок, тож руками дописана версія не повинна
 * ронити рендер пропущеним полем.
 */
class Cv
{
    const DEFAULT = 'default';

    private const DIR = __DIR__ . '/../data';

    private const PORTFOLIO_FILE = self::DIR . '/shared/portfolio.json';

    private const PROFILE_DEFAULTS = [
        'name' => '',
        'title' => '',
        'photo' => '',
        'location' => '',
        'email' => '',
        'phone' => '',
        'summary' => '',
        'shortSummary' => '',
    ];

    private const EXPERIENCE_DEFAULTS = [
        'role' => '',
        'company' => '',
        'location' => '',
        'from' => '',
        'to' => '',
        'summary' => '',
        'items' => [],
        'shortSummary' => '',
        'shortItems' => [],
    ];

    private const EDUCATION_DEFAULTS = [
        'degree' => '',
        'school' => '',
        'location' => '',
        'from' => '',
        'to' => '',
    ];

    private const LANGUAGE_DEFAULTS = [
        'name' => '',
        'level' => '',
    ];

    /**
     * icon — ім'я PNG з resources/img/icons без розширення (phone, github…)
     * або символ з DejaVu Sans (BMP). Інші гліфи, зокрема емодзі,
     * dompdf не рендерить: у PDF буде порожній прямокутник.
     */
    private const CONTACT_DEFAULTS = [
        'icon' => '',
        'text' => '',
        'url' => null,
    ];

    private const SOCIAL_DEFAULTS = [
        'icon' => '',
        'label' => '',
        'text' => '',
        'url' => null,
    ];

    private const PORTFOLIO_DEFAULTS = [
        'title' => '',
        'image' => '',
        'stack' => [],
        'text' => [],
    ];

    private function __construct(
        private string $version,
        private array $data,
    ) {
    }

    public static function load(?string $version = null): self
    {
        $version = self::resolve($version);
        $raw = file_get_contents(self::path($version));

        try {
            $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \InvalidArgumentException(sprintf(
                'Версія "%s": некоректний JSON — %s',
                $version,
                $e->getMessage()
            ));
        }

        if (! is_array($data)) {
            throw new \InvalidArgumentException(sprintf('Версія "%s": очікувався об\'єкт у корені файлу.', $version));
        }

        return new self($version, $data);
    }

    /**
     * Версії, знайдені в data/: ім'я файлу без розширення => поле label.
     *
     * @return array<string, string>
     */
    public static function available(): array
    {
        $versions = [];

        foreach (glob(self::DIR . '/*.json') ?: [] as $file) {
            $name = basename($file, '.json');
            $data = json_decode((string) file_get_contents($file), true);

            $versions[$name] = is_array($data) && isset($data['label']) ? (string) $data['label'] : '';
        }

        ksort($versions);

        return $versions;
    }

    public static function resolve(?string $name): string
    {
        $name = trim((string) $name);

        if ($name === '') {
            $name = self::DEFAULT;
        }

        $available = self::available();

        if (! isset($available[$name])) {
            throw new \InvalidArgumentException(sprintf(
                'Невідома версія даних "%s". Доступні: %s',
                $name,
                $available === [] ? '— (тека data/ порожня)' : implode(', ', array_keys($available))
            ));
        }

        return $name;
    }

    /** Приймає лише ім'я, що вже пройшло resolve(). */
    private static function path(string $version): string
    {
        return self::DIR . '/' . $version . '.json';
    }

    public function version(): string
    {
        return $this->version;
    }

    public function label(): string
    {
        return (string) ($this->data['label'] ?? '');
    }

    public function profile(): array
    {
        return self::fill($this->data['profile'] ?? [], self::PROFILE_DEFAULTS);
    }

    public function contacts(): array
    {
        return self::fillEach($this->data['contacts'] ?? [], self::CONTACT_DEFAULTS);
    }

    public function socials(): array
    {
        return self::fillEach($this->data['socials'] ?? [], self::SOCIAL_DEFAULTS);
    }

    public function experience(): array
    {
        return self::fillEach($this->data['experience'] ?? [], self::EXPERIENCE_DEFAULTS);
    }

    public function education(): array
    {
        return self::fillEach($this->data['education'] ?? [], self::EDUCATION_DEFAULTS);
    }

    public function languages(): array
    {
        return self::fillEach($this->data['languages'] ?? [], self::LANGUAGE_DEFAULTS);
    }

    /**
     * Спільне для всіх версій портфоліо. Файл необов'язковий: без нього
     * modern просто рендериться без секції проєктів, а classic її й так
     * не виводить. А от зламаний JSON — це помилка, і про неї краще знати.
     */
    public function portfolio(): array
    {
        if (! is_file(self::PORTFOLIO_FILE)) {
            return [];
        }

        try {
            $projects = json_decode((string) file_get_contents(self::PORTFOLIO_FILE), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \InvalidArgumentException('data/shared/portfolio.json: некоректний JSON — ' . $e->getMessage());
        }

        return self::fillEach($projects, self::PORTFOLIO_DEFAULTS);
    }

    public function skills(): Skills
    {
        $skills = $this->data['skills'] ?? [];

        return new Skills(
            (array) ($skills['top'] ?? []),
            (array) ($skills['groups'] ?? []),
            (array) ($skills['familiar'] ?? []),
        );
    }

    private static function fill(mixed $entry, array $defaults): array
    {
        return is_array($entry) ? $entry + $defaults : $defaults;
    }

    private static function fillEach(mixed $entries, array $defaults): array
    {
        if (! is_array($entries)) {
            return [];
        }

        return array_values(array_map(
            static fn ($entry) => self::fill($entry, $defaults),
            $entries
        ));
    }
}
