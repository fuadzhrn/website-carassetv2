<?php

namespace App\Http\Requests\Admin\Pages\Partnership;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates one Program Kemitraan section's content per PROMPT 19's locked
 * JSON schema. Mirrors UpdateHomeSectionRequest (PROMPT 17) /
 * UpdateBusinessSectionRequest (PROMPT 18) — which section key applies is
 * decided by the {sectionKey} route parameter, already constrained to the
 * 5 known keys at the route level.
 *
 * Locked/structural sub-fields deliberately have NO validation rule here
 * (program-selector's owner/driver anchors, packages' unit_count): since
 * ContentService::mergeContent() merges associative sub-arrays field-by-
 * field, any key never accepted from the request can never be written by
 * an admin submission and permanently falls back to config/partnership-
 * content.php's value — the same mechanism that keeps position-locked
 * icons safe elsewhere, applied here to lock specific fields instead.
 *
 * "Featured package" is a single content.featured_package selector (one
 * radio group) rather than 3 independent is_featured booleans — this
 * structurally guarantees at most one package is featured, no separate
 * cross-field validator needed.
 */
class UpdatePartnershipSectionRequest extends FormRequest
{
    private const PACKAGE_KEYS = ['one_unit', 'five_units', 'ten_units'];

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
            'program-selector' => $this->programSelectorRules(),
            'owner-program' => $this->ownerProgramRules(),
            'driver-program' => $this->driverProgramRules(),
            'packages-benefits' => $this->packagesBenefitsRules(),
            'terms' => $this->termsRules(),
            default => [],
        };

        return array_merge(['is_active' => ['boolean']], $rules);
    }

    /**
     * @return array<string, mixed>
     */
    private function programSelectorRules(): array
    {
        $rules = [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:200'],
            'content.description' => ['required', 'string', 'max:500'],
        ];

        foreach (['owner', 'driver'] as $path) {
            $rules["content.{$path}.label"] = ['nullable', 'string', 'max:60'];
            $rules["content.{$path}.title"] = ['required', 'string', 'max:100'];
            $rules["content.{$path}.description"] = ['required', 'string', 'max:300'];
            $rules["content.{$path}.cta_label"] = ['nullable', 'string', 'max:60'];
            $rules["content.{$path}.is_active"] = ['boolean'];
        }

        return $rules;
    }

    /**
     * @return array<string, mixed>
     */
    private function ownerProgramRules(): array
    {
        $rules = array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.narrative' => ['required', 'string', 'max:900'],
            'content.image_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.image_alt' => ['nullable', 'string', 'max:255'],
            'content.callouts' => ['array', 'max:4'],
            'content.callouts.*.label' => ['nullable', 'string', 'max:60'],
            'content.callouts.*.is_active' => ['boolean'],
        ], $this->ctaRules('content.cta'));

        foreach (['partner_roles', 'carasset_roles', 'benefits'] as $group) {
            $rules = array_merge($rules, $this->itemListRules("content.{$group}", 4, 180));
        }

        $rules['content.microcopy'] = ['nullable', 'string', 'max:300'];

        return $rules;
    }

    /**
     * @return array<string, mixed>
     */
    private function driverProgramRules(): array
    {
        $rules = array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:200'],
            'content.narrative' => ['required', 'string', 'max:900'],
            'content.image_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.image_alt' => ['nullable', 'string', 'max:255'],
            'content.timeline' => ['array', 'max:5'],
            'content.timeline.*.item_key' => $this->itemKeyRule(),
            'content.timeline.*.label' => ['nullable', 'string', 'max:30'],
            'content.timeline.*.title' => ['nullable', 'string', 'max:100'],
            'content.timeline.*.description' => ['nullable', 'string', 'max:350'],
            'content.timeline.*.is_active' => ['boolean'],
            'content.after_unit_panel.title' => ['nullable', 'string', 'max:100'],
            'content.after_unit_panel.description' => ['nullable', 'string', 'max:200'],
            'content.after_unit_panel.is_active' => ['boolean'],
            'content.note' => ['nullable', 'string', 'max:400'],
        ], $this->ctaRules('content.cta'));

        return array_merge($rules, $this->itemListRules('content.after_unit_panel.items', 3, 180));
    }

    /**
     * @return array<string, mixed>
     */
    private function packagesBenefitsRules(): array
    {
        $rules = [
            'content.title' => ['required', 'string', 'max:200'],
            'content.description' => ['required', 'string', 'max:400'],
            'content.featured_package' => ['nullable', 'string', Rule::in(self::PACKAGE_KEYS)],
            'content.disclaimer' => ['nullable', 'string', 'max:300'],
        ];

        foreach (self::PACKAGE_KEYS as $packageKey) {
            $prefix = "content.packages.{$packageKey}";

            $rules["{$prefix}.label"] = ['nullable', 'string', 'max:60'];
            $rules["{$prefix}.title"] = ['nullable', 'string', 'max:40'];
            $rules["{$prefix}.description"] = ['nullable', 'string', 'max:300'];
            $rules["{$prefix}.is_active"] = ['boolean'];

            $rules = array_merge(
                $rules,
                $this->itemListRules("{$prefix}.benefits", 3, 150),
                $this->ctaRules("{$prefix}.cta")
            );
        }

        return $rules;
    }

    /**
     * @return array<string, mixed>
     */
    private function termsRules(): array
    {
        $rules = array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:200'],
            'content.description' => ['required', 'string', 'max:400'],
            'content.checkpoints' => ['array', 'max:4'],
            'content.checkpoints.*.title' => ['nullable', 'string', 'max:40'],
            'content.checkpoints.*.is_active' => ['boolean'],
            'content.verification.title' => ['nullable', 'string', 'max:100'],
            'content.verification.is_active' => ['boolean'],
            'content.payment.title' => ['nullable', 'string', 'max:100'],
            'content.payment.is_active' => ['boolean'],
            // Kalimat asli mengandung <strong> di sekitar frasa terakhir —
            // disimpan sebagai teks polos saja (tidak ada HTML mentah yang
            // diterima/disimpan dari input admin).
            'content.cancellation.title' => ['nullable', 'string', 'max:100'],
            'content.cancellation.description' => ['nullable', 'string', 'max:400'],
            'content.cancellation.is_active' => ['boolean'],
            'content.rights_obligations.title' => ['nullable', 'string', 'max:100'],
            'content.rights_obligations.is_active' => ['boolean'],
            'content.operational_terms.title' => ['nullable', 'string', 'max:100'],
            'content.operational_terms.is_active' => ['boolean'],
            'content.legal_note' => ['nullable', 'string', 'max:500'],
            'content.cta_title' => ['nullable', 'string', 'max:200'],
            'content.cta_description' => ['nullable', 'string', 'max:400'],
        ],
            $this->itemListRules('content.verification.items', 4, 200),
            $this->itemListRules('content.payment.items', 3, 200),
            $this->itemListRules('content.operational_terms.items', 5, 200),
            $this->ctaRules('content.primary_cta'),
            $this->ctaRules('content.secondary_cta'),
        );

        $rules['content.rights_obligations.items'] = ['array', 'max:4'];
        $rules['content.rights_obligations.items.*.item_key'] = $this->itemKeyRule();
        $rules['content.rights_obligations.items.*.label'] = ['nullable', 'string', 'max:60'];
        $rules['content.rights_obligations.items.*.text'] = ['nullable', 'string', 'max:200'];
        $rules['content.rights_obligations.items.*.is_active'] = ['boolean'];

        return $rules;
    }

    /**
     * Shared rule set for a fixed-slot flat {item_key,text,is_active} list.
     *
     * @return array<string, mixed>
     */
    private function itemListRules(string $prefix, int $max, int $textMax): array
    {
        return [
            "{$prefix}" => ['array', "max:{$max}"],
            "{$prefix}.*.item_key" => $this->itemKeyRule(),
            "{$prefix}.*.text" => ['nullable', 'string', "max:{$textMax}"],
            "{$prefix}.*.is_active" => ['boolean'],
        ];
    }

    /**
     * item_key is an opaque identifier only — never HTML, never used for
     * authorization, only for the JS move-up/down + potential future
     * add/remove UI to track which slot's values are which.
     *
     * @return array<int, mixed>
     */
    private function itemKeyRule(): array
    {
        return ['nullable', 'string', 'max:40', 'regex:/^[A-Za-z0-9_-]+$/'];
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
     * UpdateHomeSectionRequest/UpdateBusinessSectionRequest: trim strings,
     * coerce checkbox booleans, null-out empty media IDs, and clear CTA
     * fields that don't belong to the chosen destination_type / aren't
     * whitelisted.
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
