<?php

namespace App\Http\Requests\Admin\Seo;

use App\Rules\ValidCanonicalUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates one page's Draft SEO submission. Never accepts slug,
 * route_name, page status, sitemap fields, heading data, HTML, or any
 * workflow/publish metadata (published_at/published_by/seo_workflow_status)
 * — those are either read-only or system-set, never client input.
 */
class UpdatePageSeoRequest extends FormRequest
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
        return [
            'meta_title' => ['nullable', 'string', 'max:'.config('seo.title_max_length', 70)],
            'meta_description' => ['nullable', 'string', 'max:'.config('seo.description_max_length', 180)],
            'meta_robots' => ['required', 'string', Rule::in(['index,follow', 'noindex,nofollow'])],
            'canonical_url' => ['nullable', 'string', 'max:2048', new ValidCanonicalUrl()],
        ];
    }

    /**
     * Trim title/description/canonical, collapse empty strings to null so
     * "cleared by admin" and "never set" stay indistinguishable from each
     * other (both simply fall through to the next fallback layer), never
     * to an empty-string sentinel.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'meta_title' => $this->normalizeString($this->input('meta_title')),
            'meta_description' => $this->normalizeString($this->input('meta_description')),
            'canonical_url' => $this->normalizeString($this->input('canonical_url')),
        ]);
    }

    private function normalizeString(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
