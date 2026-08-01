<?php

namespace App\Http\Requests\Admin\Pages\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates one Business section's content per PROMPT 18's locked JSON
 * schema. Mirrors UpdateHomeSectionRequest's structure (PROMPT 17) —
 * which section key applies is decided by the {sectionKey} route
 * parameter, already constrained to the 5 known keys at the route level.
 */
class UpdateBusinessSectionRequest extends FormRequest
{
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
            'opportunity' => $this->opportunityRules(),
            'own' => $this->ownRules(),
            'operate' => $this->operateRules(),
            'grow' => $this->growRules(),
            'business-flow' => $this->businessFlowRules(),
            default => [],
        };

        return array_merge(['is_active' => ['boolean']], $rules);
    }

    /**
     * @return array<string, mixed>
     */
    private function opportunityRules(): array
    {
        return array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['required', 'string', 'max:700'],
            'content.diagram.step_1_label' => ['nullable', 'string', 'max:80'],
            'content.diagram.step_2_label' => ['nullable', 'string', 'max:80'],
            'content.diagram.step_3_label' => ['nullable', 'string', 'max:80'],
            'content.diagram.step_4_label' => ['nullable', 'string', 'max:80'],
            'content.image_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.image_alt' => ['nullable', 'string', 'max:255'],
        ], $this->ctaRules('content.cta'));
    }

    /**
     * @return array<string, mixed>
     */
    private function ownRules(): array
    {
        return [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:160'],
            'content.description' => ['required', 'string', 'max:900'],
            'content.image_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.image_alt' => ['nullable', 'string', 'max:255'],
            'content.key_points' => ['array', 'max:4'],
            'content.key_points.*.text' => ['nullable', 'string', 'max:180'],
            'content.key_points.*.is_active' => ['boolean'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function operateRules(): array
    {
        $rules = [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['required', 'string', 'max:900'],
            'content.key_points' => ['array', 'max:4'],
            'content.key_points.*.text' => ['nullable', 'string', 'max:180'],
            'content.key_points.*.is_active' => ['boolean'],
            'content.monitoring_panel.illustration_label' => ['required', 'string', 'max:100'],
            'content.monitoring_panel.panel_title' => ['nullable', 'string', 'max:120'],
        ];

        foreach (['unit_status', 'driver_profile', 'vehicle_activity', 'maintenance_schedule', 'operational_report'] as $block) {
            $rules["content.monitoring_panel.{$block}.label"] = ['nullable', 'string', 'max:80'];
            $rules["content.monitoring_panel.{$block}.value"] = ['nullable', 'string', 'max:120'];
            $rules["content.monitoring_panel.{$block}.helper"] = ['nullable', 'string', 'max:250'];
            $rules["content.monitoring_panel.{$block}.is_active"] = ['boolean'];
        }

        return $rules;
    }

    /**
     * @return array<string, mixed>
     */
    private function growRules(): array
    {
        return array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['required', 'string', 'max:800'],
            'content.stages' => ['array', 'max:4'],
            'content.stages.*.label' => ['nullable', 'string', 'max:50'],
            'content.stages.*.title' => ['nullable', 'string', 'max:100'],
            'content.stages.*.is_active' => ['boolean'],
        ], $this->ctaRules('content.cta'));
    }

    /**
     * @return array<string, mixed>
     */
    private function businessFlowRules(): array
    {
        return array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['required', 'string', 'max:700'],
            'content.stages' => ['array', 'max:5'],
            'content.stages.*.title' => ['nullable', 'string', 'max:100'],
            'content.stages.*.description' => ['nullable', 'string', 'max:350'],
            'content.stages.*.is_active' => ['boolean'],
            'content.closing_statement' => ['nullable', 'string', 'max:400'],
        ],
            $this->ctaRules('content.primary_cta'),
            $this->ctaRules('content.secondary_cta'),
        );
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
     * Normalize submitted values before validation — identical strategy to
     * UpdateHomeSectionRequest (PROMPT 17): trim strings, coerce checkbox
     * booleans, null-out empty media IDs, and clear CTA fields that don't
     * belong to the chosen destination_type / aren't whitelisted.
     */
    protected function prepareForValidation(): void
    {
        $content = $this->input('content', []);

        if (is_array($content)) {
            $content = $this->trimStrings($content);
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
