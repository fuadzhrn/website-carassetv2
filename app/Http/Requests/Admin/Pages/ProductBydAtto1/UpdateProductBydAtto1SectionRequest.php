<?php

namespace App\Http\Requests\Admin\Pages\ProductBydAtto1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Validates one Produk BYD ATTO 1 section's content per PROMPT 27
 * (FINAL)'s locked JSON schema. Mirrors UpdateAboutContactSectionRequest's
 * structure for CTA/media/repeater/item_key normalization — this page's
 * own additions: gallery repeater (temporary generic visuals) and a
 * server-enforced "at most one featured variant" gate. Whitelists fields
 * only; never accepts raw JSON/HTML, page_id, updated_by, published_by,
 * workflow_status, or revision_number from the request.
 */
class UpdateProductBydAtto1SectionRequest extends FormRequest
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
            'product-hero' => $this->heroRules(),
            'product-colors' => $this->galleryRules(),
            'product-variants' => $this->variantsRules(),
            'product-specifications' => $this->specificationsRules(),
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
            'content.model_name' => ['nullable', 'string', 'max:100'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.tagline' => ['nullable', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:1000'],

            'content.hero_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.hero_alt' => ['nullable', 'string', 'max:255'],

            'content.badges' => ['array', 'max:4'],
            'content.badges.*.item_key' => $this->itemKeyRule(),
            'content.badges.*.label' => ['nullable', 'string', 'max:80'],
            'content.badges.*.is_active' => ['boolean'],

            'content.microcopy' => ['nullable', 'string', 'max:400'],
        ],
            $this->ctaRules('content.primary_cta'),
            $this->ctaRules('content.secondary_cta'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function galleryRules(): array
    {
        return [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:700'],

            'content.gallery' => ['array', 'max:8'],
            'content.gallery.*.item_key' => $this->itemKeyRule(),
            'content.gallery.*.media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.gallery.*.alt' => ['nullable', 'string', 'max:255'],
            'content.gallery.*.caption' => ['nullable', 'string', 'max:300'],
            'content.gallery.*.view_label' => ['nullable', 'string', 'max:100'],
            'content.gallery.*.is_temporary' => ['boolean'],
            'content.gallery.*.is_active' => ['boolean'],

            'content.gallery_note' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function variantsRules(): array
    {
        return [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:700'],

            'content.data_status' => ['required', Rule::in(['draft', 'confirmed'])],
            'content.status_note' => ['nullable', 'string', 'max:300'],

            'content.variants' => ['array', 'max:5'],
            'content.variants.*.item_key' => $this->itemKeyRule(),
            'content.variants.*.name' => ['nullable', 'string', 'max:100'],
            'content.variants.*.subtitle' => ['nullable', 'string', 'max:180'],
            'content.variants.*.description' => ['nullable', 'string', 'max:700'],
            'content.variants.*.image_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.variants.*.image_alt' => ['nullable', 'string', 'max:255'],
            'content.variants.*.badge' => ['nullable', 'string', 'max:60'],
            'content.variants.*.information_status' => ['required', Rule::in(['draft', 'confirmed'])],
            'content.variants.*.is_featured' => ['boolean'],
            'content.variants.*.is_active' => ['boolean'],

            'content.variants.*.highlights' => ['array', 'max:8'],
            'content.variants.*.highlights.*.item_key' => $this->itemKeyRule(),
            'content.variants.*.highlights.*.label' => ['nullable', 'string', 'max:100'],
            'content.variants.*.highlights.*.value' => ['nullable', 'string', 'max:150'],

            'content.variants.*.specifications' => ['array', 'max:12'],
            'content.variants.*.specifications.*.item_key' => $this->itemKeyRule(),
            'content.variants.*.specifications.*.label' => ['nullable', 'string', 'max:120'],
            'content.variants.*.specifications.*.value' => ['nullable', 'string', 'max:150'],
            'content.variants.*.specifications.*.unit' => ['nullable', 'string', 'max:30'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function specificationsRules(): array
    {
        return [
            'content.eyebrow' => ['nullable', 'string', 'max:80'],
            'content.title' => ['required', 'string', 'max:180'],
            'content.description' => ['nullable', 'string', 'max:700'],

            'content.data_status' => ['required', Rule::in(['draft', 'confirmed'])],
            'content.status_note' => ['nullable', 'string', 'max:300'],

            'content.specification_categories' => ['array', 'max:6'],
            'content.specification_categories.*.item_key' => $this->itemKeyRule(),
            'content.specification_categories.*.title' => ['nullable', 'string', 'max:120'],
            'content.specification_categories.*.description' => ['nullable', 'string', 'max:500'],
            'content.specification_categories.*.is_active' => ['boolean'],

            'content.specification_categories.*.items' => ['array', 'max:10'],
            'content.specification_categories.*.items.*.item_key' => $this->itemKeyRule(),
            'content.specification_categories.*.items.*.label' => ['nullable', 'string', 'max:120'],
            'content.specification_categories.*.items.*.value' => ['nullable', 'string', 'max:180'],
            'content.specification_categories.*.items.*.unit' => ['nullable', 'string', 'max:30'],

            'content.features' => ['array', 'max:12'],
            'content.features.*.item_key' => $this->itemKeyRule(),
            'content.features.*.title' => ['nullable', 'string', 'max:140'],
            'content.features.*.description' => ['nullable', 'string', 'max:700'],
            'content.features.*.media_id' => ['nullable', 'integer', 'exists:media,id'],
            'content.features.*.media_alt' => ['nullable', 'string', 'max:255'],
            'content.features.*.is_active' => ['boolean'],
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
     * Cross-field gate: at most one featured variant among active
     * variants. This is the only cross-field check performed — never a
     * formula, never a business rule beyond cardinality.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $sectionKey = (string) $this->route('sectionKey');
            $content = $this->input('content', []);

            if ($sectionKey === 'product-variants') {
                $featuredCount = collect($content['variants'] ?? [])
                    ->filter(fn ($variant) => ($variant['is_active'] ?? true) !== false)
                    ->filter(fn ($variant) => ($variant['is_featured'] ?? false) === true)
                    ->count();

                if ($featuredCount > 1) {
                    $validator->errors()->add('content.variants', 'Hanya boleh ada satu varian unggulan (featured) yang aktif.');
                }
            }
        });
    }

    /**
     * Normalization strategy mirrors UpdateAboutContactSectionRequest:
     * every repeater list (including nested ones — variants[].highlights/
     * specifications, specification_categories[].items) gets item_key
     * backfilled and sort_order assigned server-side (never trusted from
     * the request). Color slugs are lowercased/hyphenated but names,
     * variant names, spec values, and units are never altered.
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
     * @param array<string, mixed> $content
     * @return array<string, mixed>
     */
    private function normalizeRepeaters(array $content): array
    {
        $sectionKey = (string) $this->route('sectionKey');

        if ($sectionKey === 'product-hero' && isset($content['badges']) && is_array($content['badges'])) {
            $content['badges'] = $this->normalizeRepeaterList($content['badges']);
        }

        if ($sectionKey === 'product-colors' && isset($content['gallery']) && is_array($content['gallery'])) {
            $content['gallery'] = $this->normalizeRepeaterList($content['gallery']);
        }

        if ($sectionKey === 'product-variants' && isset($content['variants']) && is_array($content['variants'])) {
            $variants = $this->normalizeRepeaterList($content['variants']);

            // Featured variant is selected via a single shared radio group
            // (content[featured_variant], value = the row's item_key) so
            // "at most one" is enforced natively by the browser, not just
            // by the withValidator() gate below. Translated here into each
            // row's own is_featured boolean, then discarded — it is never
            // itself persisted into page_sections.content.
            $featuredKey = $content['featured_variant'] ?? null;

            foreach ($variants as $index => $variant) {
                if (isset($variant['highlights']) && is_array($variant['highlights'])) {
                    $variants[$index]['highlights'] = $this->normalizeRepeaterList($variant['highlights']);
                }

                if (isset($variant['specifications']) && is_array($variant['specifications'])) {
                    $variants[$index]['specifications'] = $this->normalizeRepeaterList($variant['specifications']);
                }

                $variants[$index]['is_featured'] = $featuredKey !== null && $featuredKey !== ''
                    && ($variant['item_key'] ?? null) === $featuredKey;
            }

            unset($content['featured_variant']);
            $content['variants'] = $variants;
        }

        if ($sectionKey === 'product-specifications') {
            if (isset($content['specification_categories']) && is_array($content['specification_categories'])) {
                $categories = $this->normalizeRepeaterList($content['specification_categories']);

                foreach ($categories as $index => $category) {
                    if (isset($category['items']) && is_array($category['items'])) {
                        $categories[$index]['items'] = $this->normalizeRepeaterList($category['items']);
                    }
                }

                $content['specification_categories'] = $categories;
            }

            if (isset($content['features']) && is_array($content['features'])) {
                $content['features'] = $this->normalizeRepeaterList($content['features']);
            }
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
            } elseif (in_array($key, ['is_active', 'is_featured', 'is_temporary'], true)) {
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

            $isMediaKey = $key === 'media_id' || str_ends_with((string) $key, '_media_id');

            if ($isMediaKey) {
                $content[$key] = ($value === '' || $value === null) ? null : (int) $value;
            }
        }

        return $content;
    }
}
