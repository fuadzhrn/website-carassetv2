<?php

namespace App\Http\Requests\Admin\Pages\AboutContact;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Rules\AllowedMapEmbedUrl;

/**
 * Validates one Tentang & Kontak section's content per PROMPT 21's locked
 * JSON schema. Mirrors the Home/Business/Partnership/Simulation Form
 * Requests for CTA/media/structure handling, adding this page's own
 * concerns: repeater item_key/sort_order normalized server-side (never
 * trusted from the request), vision/mission editorial_status and legal
 * data_status completeness gates, partner URL scheme restriction, and the
 * AllowedMapEmbedUrl whitelist for map.embed_url.
 */
class UpdateAboutContactSectionRequest extends FormRequest
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
            'about' => $this->aboutRules(),
            'vision-mission-values' => $this->visionMissionValuesRules(),
            'legal-partners' => $this->legalPartnersRules(),
            'faq' => $this->faqRules(),
            'contact-form' => $this->contactFormRules(),
            default => [],
        };

        return array_merge(['is_active' => ['boolean']], $rules);
    }

    /**
     * @return array<string, mixed>
     */
    private function aboutRules(): array
    {
        return array_merge([
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.tagline' => ['nullable', 'string', 'max:180'],
            'content.narrative' => ['required', 'string', 'max:1500'],
            'content.positioning_statement' => ['nullable', 'string', 'max:500'],
            'content.image_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.image_alt' => ['nullable', 'string', 'max:255'],
        ],
            $this->ctaRules('content.primary_cta'),
            $this->ctaRules('content.secondary_cta'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function visionMissionValuesRules(): array
    {
        $rules = [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:700'],

            'content.vision.label' => ['nullable', 'string', 'max:80'],
            'content.vision.direction' => ['nullable', 'string', 'max:400'],
            'content.vision.statement' => ['nullable', 'string', 'max:1000'],
            'content.vision.editorial_status' => ['required', Rule::in(['draft', 'confirmed'])],

            'content.mission.label' => ['nullable', 'string', 'max:80'],
            'content.mission.intro' => ['nullable', 'string', 'max:500'],
            'content.mission.items' => ['array', 'max:8'],
            'content.mission.items.*.item_key' => $this->itemKeyRule(),
            'content.mission.items.*.text' => ['nullable', 'string', 'max:500'],
            'content.mission.items.*.is_active' => ['boolean'],
            'content.mission.editorial_status' => ['required', Rule::in(['draft', 'confirmed'])],
        ];

        foreach (['trust', 'growth', 'productive', 'partnership'] as $valueKey) {
            $rules["content.values.{$valueKey}.description"] = ['nullable', 'string', 'max:500'];
            $rules["content.values.{$valueKey}.is_active"] = ['boolean'];
            // title dan icon TIDAK divalidasi — dikunci, tidak pernah
            // diterima dari request (lihat komentar normalizeValues()).
        }

        return $rules;
    }

    /**
     * @return array<string, mixed>
     */
    private function legalPartnersRules(): array
    {
        return [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:900'],

            'content.legal.data_status' => ['required', Rule::in(['draft', 'confirmed'])],
            'content.legal.status_note' => ['nullable', 'string', 'max:300'],
            'content.legal.entity_name' => ['nullable', 'string', 'max:255'],
            'content.legal.registration_number' => ['nullable', 'string', 'max:255'],
            'content.legal.registered_address' => ['nullable', 'string', 'max:1000'],

            'content.legal.documents' => ['array', 'max:10'],
            'content.legal.documents.*.item_key' => $this->itemKeyRule(),
            'content.legal.documents.*.title' => ['nullable', 'string', 'max:150'],
            'content.legal.documents.*.description' => ['nullable', 'string', 'max:700'],
            'content.legal.documents.*.document_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.legal.documents.*.document_alt' => ['nullable', 'string', 'max:255'],
            'content.legal.documents.*.is_active' => ['boolean'],

            'content.partners' => ['array', 'max:12'],
            'content.partners.*.item_key' => $this->itemKeyRule(),
            'content.partners.*.name' => ['nullable', 'string', 'max:150'],
            'content.partners.*.logo_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.partners.*.logo_alt' => ['nullable', 'string', 'max:255'],
            'content.partners.*.description' => ['nullable', 'string', 'max:600'],
            'content.partners.*.url' => ['nullable', 'url', 'max:500', 'regex:/^https?:\/\//i'],
            'content.partners.*.open_new_tab' => ['boolean'],
            'content.partners.*.is_active' => ['boolean'],

            'content.partner_note' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function faqRules(): array
    {
        return [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:700'],

            'content.items' => ['array', 'max:20'],
            'content.items.*.item_key' => $this->itemKeyRule(),
            'content.items.*.question' => ['nullable', 'string', 'max:300'],
            'content.items.*.answer' => ['nullable', 'string', 'max:1500'],
            'content.items.*.is_active' => ['boolean'],

            'content.closing_note' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function contactFormRules(): array
    {
        return [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:900'],

            'content.contact_panel.title' => ['nullable', 'string', 'max:140'],
            'content.contact_panel.description' => ['nullable', 'string', 'max:700'],

            'content.form.title' => ['required', 'string', 'max:180'],
            'content.form.description' => ['nullable', 'string', 'max:700'],
            'content.form.submit_label' => ['nullable', 'string', 'max:60'],
            'content.form.microcopy' => ['nullable', 'string', 'max:500'],
            // Ditambahkan PROMPT 22 — redaksi consent form publik.
            'content.form.consent_label' => ['nullable', 'string', 'max:500'],

            'content.form.program_options' => ['array', 'max:6'],
            'content.form.program_options.*.item_key' => $this->itemKeyRule(),
            'content.form.program_options.*.label' => ['nullable', 'string', 'max:100'],
            'content.form.program_options.*.value' => ['nullable', 'alpha_dash', 'max:80'],
            'content.form.program_options.*.is_active' => ['boolean'],

            'content.map.is_active' => ['boolean'],
            'content.map.embed_url' => ['nullable', 'string', 'max:2000', new AllowedMapEmbedUrl()],
            'content.map.title' => ['nullable', 'string', 'max:180'],
        ];
    }

    /**
     * item_key is an opaque identifier only — never HTML, never used for
     * authorization, only for the JS move-up/down engine to track which
     * slot's values are which.
     *
     * @return array<int, mixed>
     */
    private function itemKeyRule(): array
    {
        return ['nullable', 'string', 'max:60', 'regex:/^[A-Za-z0-9_-]+$/'];
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
     * Completeness gates for editorial/legal "confirmed" status, and the
     * program-option-value-uniqueness check. These are the only
     * cross-field checks performed — never a formula, never a business
     * rule beyond "is this required field present / is this value unique".
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $sectionKey = (string) $this->route('sectionKey');
            $content = $this->input('content', []);

            if ($sectionKey === 'vision-mission-values') {
                if (($content['vision']['editorial_status'] ?? null) === 'confirmed'
                    && ($content['vision']['statement'] ?? null) === null) {
                    $validator->errors()->add('content.vision.statement', 'Redaksi visi wajib diisi bila status redaksi adalah "Telah Dikonfirmasi".');
                }

                if (($content['mission']['editorial_status'] ?? null) === 'confirmed') {
                    $hasActiveItem = collect($content['mission']['items'] ?? [])
                        ->contains(fn ($item) => ($item['is_active'] ?? true) !== false && ($item['text'] ?? null) !== null);

                    if (! $hasActiveItem) {
                        $validator->errors()->add('content.mission.items', 'Minimal satu poin misi aktif dan terisi wajib ada bila status redaksi adalah "Telah Dikonfirmasi".');
                    }
                }
            }

            if ($sectionKey === 'legal-partners' && ($content['legal']['data_status'] ?? null) === 'confirmed') {
                foreach (['entity_name', 'registration_number', 'registered_address'] as $field) {
                    if (($content['legal'][$field] ?? null) === null) {
                        $validator->errors()->add("content.legal.{$field}", 'Field ini wajib diisi bila status legalitas adalah "Telah Dikonfirmasi".');
                    }
                }
            }

            if ($sectionKey === 'contact-form') {
                $activeValues = collect($content['form']['program_options'] ?? [])
                    ->filter(fn ($option) => ($option['is_active'] ?? true) !== false)
                    ->pluck('value')
                    ->filter(fn ($value) => $value !== null);

                if ($activeValues->count() !== $activeValues->unique()->count()) {
                    $validator->errors()->add('content.form.program_options', 'Value pilihan program yang aktif tidak boleh duplikat.');
                }
            }
        });
    }

    /**
     * Normalization strategy mirrors Home/Business/Partnership/Simulation's
     * Form Requests, with this page's addition: every repeater list gets
     * item_key backfilled and sort_order assigned server-side (never
     * trusted from the request), and empty FAQ items are dropped.
     */
    protected function prepareForValidation(): void
    {
        $content = $this->input('content', []);

        if (is_array($content)) {
            $content = $this->trimStrings($content);
            $content = $this->normalizeRepeaters($content);
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
     * Locates every known repeater list by section key and reindexes it,
     * backfilling item_key and assigning sort_order = index+1 — raw
     * sort_order/item_key from the request is never trusted.
     *
     * @param array<string, mixed> $content
     * @return array<string, mixed>
     */
    private function normalizeRepeaters(array $content): array
    {
        $sectionKey = (string) $this->route('sectionKey');

        if ($sectionKey === 'vision-mission-values' && isset($content['mission']['items']) && is_array($content['mission']['items'])) {
            $content['mission']['items'] = $this->normalizeRepeaterList($content['mission']['items']);
        }

        if ($sectionKey === 'legal-partners') {
            if (isset($content['legal']['documents']) && is_array($content['legal']['documents'])) {
                $content['legal']['documents'] = $this->normalizeRepeaterList($content['legal']['documents']);
            }

            if (isset($content['partners']) && is_array($content['partners'])) {
                $content['partners'] = $this->normalizeRepeaterList($content['partners']);
            }
        }

        if ($sectionKey === 'faq' && isset($content['items']) && is_array($content['items'])) {
            $items = array_values(array_filter($content['items'], function ($item) {
                return ($item['question'] ?? null) !== null && ($item['answer'] ?? null) !== null;
            }));

            $content['items'] = $this->normalizeRepeaterList($items);
        }

        if ($sectionKey === 'contact-form' && isset($content['form']['program_options']) && is_array($content['form']['program_options'])) {
            $content['form']['program_options'] = $this->normalizeRepeaterList($content['form']['program_options']);
        }

        return $content;
    }

    /**
     * @param array<int, array<string, mixed>> $items
     * @return array<int, array<string, mixed>>
     */
    private function normalizeRepeaterList(array $items): array
    {
        $reindexed = array_values($items);

        foreach ($reindexed as $index => $item) {
            if (! is_array($item)) {
                continue;
            }

            $itemKey = $item['item_key'] ?? null;

            if (! is_string($itemKey) || $itemKey === '' || preg_match('/^[A-Za-z0-9_-]+$/', $itemKey) !== 1) {
                $itemKey = Str::random(20);
            }

            $item['item_key'] = $itemKey;
            $item['sort_order'] = $index + 1;

            $reindexed[$index] = $item;
        }

        return $reindexed;
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
