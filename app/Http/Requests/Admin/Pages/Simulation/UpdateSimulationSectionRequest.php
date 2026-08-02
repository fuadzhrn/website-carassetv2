<?php

namespace App\Http\Requests\Admin\Pages\Simulation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates one Simulasi & Perlindungan section's content per PROMPT 20's
 * locked JSON schema. Mirrors the Home/Business/Partnership Form Requests
 * for CTA/media/structure handling, but adds the numeric-safety rules this
 * page requires:
 *
 * - Every nominal is integer|nullable — never a formatted string, never a
 *   float, negative values rejected.
 * - Locked/undetermined fields (revenue_share.value/format, unit_count)
 *   have NO validation rule at all, so they can never be written by an
 *   admin submission and permanently fall back to
 *   config/simulation-content.php's value via ContentService::mergeContent()
 *   — the same "no rule = locked" mechanism used for Partnership's
 *   packages.*.unit_count (PROMPT 19).
 * - data_status (draft|confirmed) is validated per-section, with a
 *   withValidator() pass enforcing that "confirmed" cannot be chosen while
 *   that section's main numeric fields are still null — this is the only
 *   cross-field check performed; it is a completeness gate, never a
 *   formula or equation between fields.
 */
class UpdateSimulationSectionRequest extends FormRequest
{
    private const NOMINAL_MAX = 1000000000000;

    private const OPERATIONAL_DAYS_MAX = 366;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $sectionKey = (string) $this->route('sectionKey');

        $rules = match ($sectionKey) {
            'assumptions' => $this->assumptionsRules(),
            'one-unit' => $this->oneUnitRules(),
            'multiple-units' => $this->multipleUnitsRules(),
            'protection-monitoring' => $this->protectionMonitoringRules(),
            'disclaimer' => $this->disclaimerRules(),
            default => [],
        };

        return array_merge(['is_active' => ['boolean']], $rules);
    }

    /**
     * @return array<string, mixed>
     */
    private function assumptionsRules(): array
    {
        return [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:900'],

            'content.data_status' => ['required', Rule::in(['draft', 'confirmed'])],
            'content.status_note' => ['nullable', 'string', 'max:300'],

            'content.operational_days.label' => ['nullable', 'string', 'max:100'],
            'content.operational_days.value' => ['nullable', 'integer', 'min:0', 'max:'.self::OPERATIONAL_DAYS_MAX],
            'content.operational_days.helper' => ['nullable', 'string', 'max:300'],

            'content.daily_result.label' => ['nullable', 'string', 'max:100'],
            'content.daily_result.value' => $this->nominalRule(),
            'content.daily_result.helper' => ['nullable', 'string', 'max:300'],

            'content.operating_cost.label' => ['nullable', 'string', 'max:100'],
            'content.operating_cost.value' => $this->nominalRule(),
            'content.operating_cost.helper' => ['nullable', 'string', 'max:300'],

            'content.vehicle_installment.label' => ['nullable', 'string', 'max:100'],
            'content.vehicle_installment.value' => $this->nominalRule(),
            'content.vehicle_installment.helper' => ['nullable', 'string', 'max:300'],

            'content.management_component.label' => ['nullable', 'string', 'max:100'],
            'content.management_component.value' => $this->nominalRule(),
            'content.management_component.helper' => ['nullable', 'string', 'max:300'],

            // revenue_share.value / .format sengaja TIDAK divalidasi —
            // jenisnya (persen/rupiah) belum ditentukan audit, field
            // terkunci sampai resmi ditentukan. Hanya label/helper yang
            // dapat diubah admin.
            'content.revenue_share.label' => ['nullable', 'string', 'max:100'],
            'content.revenue_share.helper' => ['nullable', 'string', 'max:300'],

            'content.callout.title' => ['nullable', 'string', 'max:140'],
            'content.callout.description' => ['nullable', 'string', 'max:500'],
            'content.callout.is_active' => ['boolean'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function oneUnitRules(): array
    {
        return array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:900'],

            'content.data_status' => ['required', Rule::in(['draft', 'confirmed'])],
            'content.status_note' => ['nullable', 'string', 'max:300'],

            'content.gross_operational_result.label' => ['nullable', 'string', 'max:120'],
            'content.gross_operational_result.value' => $this->nominalRule(),
            'content.gross_operational_result.helper' => ['nullable', 'string', 'max:300'],

            'content.operating_cost.label' => ['nullable', 'string', 'max:120'],
            'content.operating_cost.value' => $this->nominalRule(),
            'content.operating_cost.helper' => ['nullable', 'string', 'max:300'],

            'content.vehicle_obligation.label' => ['nullable', 'string', 'max:120'],
            'content.vehicle_obligation.value' => $this->nominalRule(),
            'content.vehicle_obligation.helper' => ['nullable', 'string', 'max:300'],

            'content.management_component.label' => ['nullable', 'string', 'max:120'],
            'content.management_component.value' => $this->nominalRule(),
            'content.management_component.helper' => ['nullable', 'string', 'max:300'],

            'content.projected_partner_result.label' => ['nullable', 'string', 'max:120'],
            'content.projected_partner_result.value' => $this->nominalRule(),
            'content.projected_partner_result.helper' => ['nullable', 'string', 'max:300'],

            'content.summary_note' => ['nullable', 'string', 'max:500'],
        ], $this->ctaRules('content.cta'));
    }

    /**
     * @return array<string, mixed>
     */
    private function multipleUnitsRules(): array
    {
        $rules = [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:900'],

            'content.data_status' => ['required', Rule::in(['draft', 'confirmed'])],
            'content.status_note' => ['nullable', 'string', 'max:300'],

            'content.comparison_note' => ['nullable', 'string', 'max:600'],
        ];

        foreach (['one_unit', 'five_units', 'ten_units'] as $unitKey) {
            $prefix = "content.units.{$unitKey}";

            $rules["{$prefix}.label"] = ['nullable', 'string', 'max:80'];
            $rules["{$prefix}.description"] = ['nullable', 'string', 'max:400'];
            $rules["{$prefix}.gross_operational_result"] = $this->nominalRule();
            $rules["{$prefix}.operating_cost"] = $this->nominalRule();
            $rules["{$prefix}.vehicle_obligation"] = $this->nominalRule();
            $rules["{$prefix}.management_component"] = $this->nominalRule();
            $rules["{$prefix}.projected_partner_result"] = $this->nominalRule();
            $rules["{$prefix}.note"] = ['nullable', 'string', 'max:400'];
            $rules["{$prefix}.is_active"] = ['boolean'];
            // unit_count sengaja TIDAK divalidasi — dikunci server per
            // key (1/5/10), tidak pernah dipercaya dari request.
        }

        return array_merge($rules, $this->ctaRules('content.cta'));
    }

    /**
     * @return array<string, mixed>
     */
    private function protectionMonitoringRules(): array
    {
        $rules = [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:900'],

            'content.image_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.image_alt' => ['nullable', 'string', 'max:255'],

            'content.callout.title' => ['nullable', 'string', 'max:140'],
            'content.callout.description' => ['nullable', 'string', 'max:500'],
            'content.callout.is_active' => ['boolean'],
        ];

        foreach (['insurance', 'warranty', 'gps', 'monitoring', 'maintenance', 'reporting'] as $featureKey) {
            $rules["content.features.{$featureKey}.title"] = ['nullable', 'string', 'max:120'];
            $rules["content.features.{$featureKey}.description"] = ['nullable', 'string', 'max:500'];
            $rules["content.features.{$featureKey}.is_active"] = ['boolean'];
        }

        return array_merge($rules, $this->ctaRules('content.cta'));
    }

    /**
     * @return array<string, mixed>
     */
    private function disclaimerRules(): array
    {
        return array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:1500'],

            'content.points' => ['array', 'max:6'],
            'content.points.*.item_key' => ['nullable', 'string', 'max:60', 'regex:/^[A-Za-z0-9_-]+$/'],
            'content.points.*.text' => ['nullable', 'string', 'max:500'],
            'content.points.*.is_active' => ['boolean'],

            'content.cta_title' => ['nullable', 'string', 'max:180'],
            'content.cta_description' => ['nullable', 'string', 'max:500'],
            'content.microcopy' => ['nullable', 'string', 'max:500'],
        ],
            $this->ctaRules('content.primary_cta'),
            $this->ctaRules('content.secondary_cta'),
        );
    }

    /**
     * Shared nominal Rupiah rule: integer, nullable, never negative, capped
     * at a safe upper bound. Never accepts a formatted string ("Rp5.100.000")
     * — Laravel's `integer` rule rejects thousand separators, and
     * prepareForValidation() below explicitly blanks empty strings to null
     * rather than letting intval('') silently become 0.
     *
     * @return array<int, mixed>
     */
    private function nominalRule(): array
    {
        return ['nullable', 'integer', 'min:0', 'max:'.self::NOMINAL_MAX];
    }

    /**
     * Shared validation rules for a CTA object at the given dot-path.
     *
     * @return array<string, mixed>
     */
    private function ctaRules(string $prefix): array
    {
        return [
            "{$prefix}.label" => ['nullable', 'string', 'max:60'],
            "{$prefix}.destination_type" => ['nullable', Rule::in(['internal', 'external', 'none'])],
            "{$prefix}.route_name" => ['nullable', 'string', Rule::in(config('cms-links.routes', []))],
            "{$prefix}.anchor" => ['nullable', 'string', 'max:100'],
            "{$prefix}.external_url" => ['nullable', 'url', 'max:500'],
            "{$prefix}.open_new_tab" => ['boolean'],
            "{$prefix}.is_active" => ['boolean'],
        ];
    }

    /**
     * Enforces that data_status can only be "confirmed" once that
     * section's main numeric fields are filled — a completeness gate,
     * never a formula between fields (no sums/products are checked, only
     * "is this required field present").
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $sectionKey = (string) $this->route('sectionKey');
            $content = $this->input('content', []);

            if (($content['data_status'] ?? null) !== 'confirmed') {
                return;
            }

            $mainFieldsByField = match ($sectionKey) {
                'assumptions' => [
                    'content.operational_days.value' => $content['operational_days']['value'] ?? null,
                    'content.daily_result.value' => $content['daily_result']['value'] ?? null,
                    'content.operating_cost.value' => $content['operating_cost']['value'] ?? null,
                    'content.vehicle_installment.value' => $content['vehicle_installment']['value'] ?? null,
                    'content.management_component.value' => $content['management_component']['value'] ?? null,
                ],
                'one-unit' => [
                    'content.gross_operational_result.value' => $content['gross_operational_result']['value'] ?? null,
                    'content.operating_cost.value' => $content['operating_cost']['value'] ?? null,
                    'content.vehicle_obligation.value' => $content['vehicle_obligation']['value'] ?? null,
                    'content.management_component.value' => $content['management_component']['value'] ?? null,
                    'content.projected_partner_result.value' => $content['projected_partner_result']['value'] ?? null,
                ],
                default => [],
            };

            foreach ($mainFieldsByField as $field => $value) {
                if ($value === null) {
                    $validator->errors()->add($field, 'Field ini wajib diisi bila status data adalah "Telah Dikonfirmasi".');
                }
            }

            if ($sectionKey === 'multiple-units') {
                foreach (['one_unit', 'five_units', 'ten_units'] as $unitKey) {
                    $unit = $content['units'][$unitKey] ?? [];

                    if (($unit['is_active'] ?? true) === false) {
                        continue;
                    }

                    foreach (['gross_operational_result', 'operating_cost', 'vehicle_obligation', 'management_component', 'projected_partner_result'] as $field) {
                        if (($unit[$field] ?? null) === null) {
                            $validator->errors()->add("content.units.{$unitKey}.{$field}", 'Field ini wajib diisi bila status data adalah "Telah Dikonfirmasi" dan panel aktif.');
                        }
                    }
                }
            }
        });
    }

    /**
     * Normalization strategy mirrors Home/Business/Partnership's Form
     * Requests, with one addition critical to this page: empty-string
     * numeric inputs become null (never intval('') === 0), and "0" is
     * preserved as an explicit integer 0 — null and 0 are never conflated.
     */
    protected function prepareForValidation(): void
    {
        $content = $this->input('content', []);

        if (is_array($content)) {
            $content = $this->trimStrings($content);
            $content = $this->normalizeNumerics($content);
            $content = $this->normalizeCtas($content);
            $content = $this->normalizeMediaIds($content);
        }

        $this->merge([
            'content' => $content,
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * @param array<string, mixed> $content
     * @return array<string, mixed>
     */
    private function trimStrings(array $content): array
    {
        foreach ($content as $key => $value) {
            if (is_string($value)) {
                $trimmed = trim($value);
                $content[$key] = $trimmed === '' ? null : $trimmed;
            } elseif (is_array($value)) {
                $content[$key] = $this->trimStrings($value);
            }
        }

        return $content;
    }

    /**
     * Numeric fields in this page's schema are always named "value" (in a
     * {label,value,helper} triple) or one of the fixed nominal keys inside
     * a multiple-units unit panel, or operational_days handled the same
     * way. An empty string always becomes null here — never 0 — and a
     * literal "0" becomes integer 0, preserving the null-vs-zero
     * distinction PROMPT 20 requires throughout.
     *
     * @param array<string, mixed> $content
     * @return array<string, mixed>
     */
    private function normalizeNumerics(array $content): array
    {
        $numericKeys = [
            'value', 'gross_operational_result', 'operating_cost',
            'vehicle_obligation', 'vehicle_installment', 'management_component',
            'projected_partner_result', 'daily_result',
        ];

        foreach ($content as $key => $value) {
            if (is_array($value)) {
                $content[$key] = $this->normalizeNumerics($value);

                continue;
            }

            if (in_array($key, $numericKeys, true)) {
                $content[$key] = $this->toNullableInteger($value);
            }
        }

        return $content;
    }

    /**
     * Explicit empty-vs-zero-vs-invalid handling — never intval('').
     */
    private function toNullableInteger(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && preg_match('/^-?\d+$/', trim($value)) === 1) {
            return (int) trim($value);
        }

        // Leave anything else (e.g. "5.100.000", "abc") untouched so the
        // `integer` validation rule rejects it explicitly instead of this
        // normalizer silently mangling it into a number.
        return $value;
    }

    /**
     * @param array<string, mixed> $content
     * @return array<string, mixed>
     */
    private function normalizeCtas(array $content): array
    {
        $looksLikeCta = array_key_exists('destination_type', $content)
            && array_key_exists('route_name', $content)
            && array_key_exists('anchor', $content)
            && array_key_exists('external_url', $content);

        if ($looksLikeCta) {
            return $this->normalizeSingleCta($content);
        }

        foreach ($content as $key => $value) {
            if (is_array($value)) {
                $content[$key] = $this->normalizeCtas($value);
            } elseif ($key === 'is_active') {
                $content[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        }

        return $content;
    }

    /**
     * @param array<string, mixed> $cta
     * @return array<string, mixed>
     */
    private function normalizeSingleCta(array $cta): array
    {
        $type = $cta['destination_type'] ?? 'none';

        if ($type === 'internal') {
            $cta['external_url'] = null;
            $routeName = $cta['route_name'] ?? null;
            $allowedAnchors = config("cms-links.anchors.{$routeName}", []);

            if (! $routeName || ! in_array($cta['anchor'] ?? null, $allowedAnchors, true)) {
                $cta['anchor'] = null;
            }
        } elseif ($type === 'external') {
            $cta['route_name'] = null;
            $cta['anchor'] = null;
        } else {
            $cta['route_name'] = null;
            $cta['anchor'] = null;
            $cta['external_url'] = null;
        }

        $cta['open_new_tab'] = filter_var($cta['open_new_tab'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $cta['is_active'] = filter_var($cta['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN);

        return $cta;
    }

    /**
     * @param array<string, mixed> $content
     * @return array<string, mixed>
     */
    private function normalizeMediaIds(array $content): array
    {
        foreach ($content as $key => $value) {
            if (is_array($value)) {
                $content[$key] = $this->normalizeMediaIds($value);

                continue;
            }

            if (str_ends_with((string) $key, '_media_id')) {
                $content[$key] = ($value === '' || $value === null) ? null : (int) $value;
            }
        }

        return $content;
    }
}
