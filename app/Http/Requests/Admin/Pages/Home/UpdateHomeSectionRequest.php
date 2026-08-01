<?php

namespace App\Http\Requests\Admin\Pages\Home;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates one Home section's content per PROMPT 17's locked JSON schema.
 *
 * Which rule set applies is decided by the {sectionKey} route parameter
 * (already constrained to the 5 known keys at the route level). Only the
 * fields declared here are ever accepted — nothing free-form, no HTML,
 * no arbitrary section keys, no step/benefit slots beyond the fixed count.
 */
class UpdateHomeSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // auth/admin.role/admin.active middleware already gate this route;
        // FormRequest authorization stays true, consistent with the rest
        // of the admin Form Requests in this project.
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $sectionKey = (string) $this->route('sectionKey');

        $rules = match ($sectionKey) {
            'hero' => $this->heroRules(),
            'income-opportunity' => $this->incomeOpportunityRules(),
            'process-summary' => $this->processSummaryRules(),
            'partnership-choice' => $this->partnershipChoiceRules(),
            'consultation-cta' => $this->consultationCtaRules(),
            default => [],
        };

        return array_merge(['is_active' => ['boolean']], $rules);
    }

    /**
     * @return array<string, mixed>
     */
    private function heroRules(): array
    {
        return array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title_line_1' => ['required', 'string', 'max:80'],
            'content.title_line_2' => ['required', 'string', 'max:80'],
            'content.subtitle' => ['nullable', 'string', 'max:180'],
            'content.description' => ['required', 'string', 'max:600'],
            'content.status_items' => ['array', 'max:3'],
            'content.status_items.*.label' => ['nullable', 'string', 'max:80'],
            'content.status_items.*.is_active' => ['boolean'],
        ],
            $this->ctaRules('content.primary_cta'),
            $this->ctaRules('content.secondary_cta'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function incomeOpportunityRules(): array
    {
        return array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.narrative' => ['required', 'string', 'max:1200'],
            'content.editorial_statement' => ['nullable', 'string', 'max:300'],
            'content.image_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.image_alt' => ['nullable', 'string', 'max:255'],
        ], $this->ctaRules('content.cta'));
    }

    /**
     * @return array<string, mixed>
     */
    private function processSummaryRules(): array
    {
        $rules = [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['required', 'string', 'max:600'],
        ];

        foreach (['own', 'operate', 'grow'] as $step) {
            $rules["content.steps.{$step}.title"] = ['required', 'string', 'max:50'];
            $rules["content.steps.{$step}.description"] = ['required', 'string', 'max:350'];
            $rules["content.steps.{$step}.is_active"] = ['boolean'];
        }

        return array_merge($rules, $this->ctaRules('content.cta'));
    }

    /**
     * @return array<string, mixed>
     */
    private function partnershipChoiceRules(): array
    {
        $rules = [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:600'],
        ];

        foreach (['owner', 'driver'] as $program) {
            $rules["content.{$program}.eyebrow"] = ['nullable', 'string', 'max:80'];
            $rules["content.{$program}.title"] = ['required', 'string', 'max:100'];
            $rules["content.{$program}.description"] = ['required', 'string', 'max:600'];
            $rules["content.{$program}.image_media_id"] = ['nullable', 'integer', 'exists:media,id'];
            $rules["content.{$program}.image_alt"] = ['nullable', 'string', 'max:255'];
            $rules["content.{$program}.benefits"] = ['array', 'max:4'];
            $rules["content.{$program}.benefits.*.text"] = ['nullable', 'string', 'max:180'];
            $rules["content.{$program}.benefits.*.is_active"] = ['boolean'];

            $rules = array_merge($rules, $this->ctaRules("content.{$program}.cta"));
        }

        return $rules;
    }

    /**
     * @return array<string, mixed>
     */
    private function consultationCtaRules(): array
    {
        return array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['required', 'string', 'max:600'],
            'content.trust_points' => ['array', 'max:4'],
            'content.trust_points.*.text' => ['nullable', 'string', 'max:180'],
            'content.trust_points.*.is_active' => ['boolean'],
            'content.microcopy' => ['nullable', 'string', 'max:350'],
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
     * Normalize submitted values before validation:
     * - trim every string;
     * - normalize checkbox/boolean fields;
     * - empty media ID becomes null;
     * - clear CTA fields that don't belong to the chosen destination_type;
     * - drop anchors that aren't whitelisted for the chosen route_name.
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
     * Recursively find any CTA-shaped sub-array (has destination_type +
     * route_name + anchor + external_url keys) and normalize it: clear
     * fields that don't apply to the chosen type, drop non-whitelisted
     * anchors, and coerce checkboxes to real booleans.
     *
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
