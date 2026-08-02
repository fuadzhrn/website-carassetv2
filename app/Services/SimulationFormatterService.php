<?php

namespace App\Services;

use NumberFormatter;

/**
 * Formats simulation numbers for display — Rupiah, plain integers, days,
 * and percentages using the id-ID locale. This service ONLY formats; it
 * never computes, derives, or combines values (no sums, no multiplication,
 * no ratios). null always stays null (never coerced to 0 or "Rp0").
 */
class SimulationFormatterService
{
    public function formatRupiah(?int $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (class_exists(NumberFormatter::class)) {
            $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
            $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);

            $formatted = $formatter->formatCurrency($value, 'IDR');

            if ($formatted !== false) {
                return $formatted;
            }
        }

        return 'Rp'.number_format($value, 0, ',', '.');
    }

    public function formatInteger(?int $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (class_exists(NumberFormatter::class)) {
            $formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
            $formatted = $formatter->format($value);

            if ($formatted !== false) {
                return $formatted;
            }
        }

        return number_format($value, 0, ',', '.');
    }

    public function formatDays(?int $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return $this->formatInteger($value).' hari';
    }

    public function formatPercentage(int|float|null $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = rtrim(rtrim(number_format((float) $value, 2, ',', '.'), '0'), ',');

        return $trimmed.'%';
    }

    /**
     * Dispatch to the correct formatter based on a field_format string
     * ('rupiah'|'integer'|'days'|'percentage'). Returns null for an
     * unrecognized/null format or a null value.
     */
    public function displayValue(int|float|null $value, ?string $format): ?string
    {
        if ($value === null || $format === null) {
            return null;
        }

        return match ($format) {
            'rupiah' => $this->formatRupiah((int) $value),
            'days' => $this->formatDays((int) $value),
            'percentage' => $this->formatPercentage($value),
            'integer' => $this->formatInteger((int) $value),
            default => null,
        };
    }
}
