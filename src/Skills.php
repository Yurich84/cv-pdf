<?php

namespace CvPdf;

/**
 * Навички однієї версії CV. Окремий клас, а не масив, бо шаблонам
 * потрібні не самі дані, а різні їх розкладки: modern показує групи,
 * classic — плоский список у колонках.
 */
class Skills
{
    /**
     * @param string[] $top головний стек — окремий блок угорі
     * @param array<string, string[]> $groups згруповані навички
     * @param string[] $familiar
     */
    public function __construct(
        private array $top,
        private array $groups,
        private array $familiar,
    ) {
    }

    /** @return string[] */
    public function top(): array
    {
        return $this->top;
    }

    /** @return array<string, string[]> */
    public function groups(): array
    {
        return $this->groups;
    }

    /** @return string[] */
    public function familiar(): array
    {
        return $this->familiar;
    }

    /** Плоский список усіх навичок — для шаблонів без групування. */
    public function flat(): array
    {
        return $this->groups === [] ? [] : array_merge(...array_values($this->groups));
    }

    /**
     * Розкладає плоский список по $columns колонках (для табличних шаблонів).
     *
     * Кількість колонок — побажання, а не гарантія: колонки виходять рівними,
     * тому остання може бути неповною, а при малій кількості навичок їх може
     * вийти менше, ніж замовлено. Шаблон має це витримувати — особливо той,
     * що задає ширину комірки у відсотках.
     */
    public function columns(int $columns): array
    {
        $all = $this->flat();

        if ($all === [] || $columns < 1) {
            return [];
        }

        return array_chunk($all, (int) ceil(count($all) / $columns));
    }
}
