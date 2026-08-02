<?php

namespace App\Http\Requests\Public;

use App\Services\ConsultationFormTokenService;
use App\Services\ContentService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates a public consultation-form submission. Whitelists every field
 * explicitly — status/timestamps/handled_by/ip_address/user_agent/
 * consented_at are never accepted here, they are always set server-side
 * (see ContactMessageService::create()). The honeypot ("website") and the
 * minimum-fill-time token ("form_token") are basic anti-spam checks, never
 * a substitute for CSRF (@csrf remains separately enforced by the `web`
 * middleware group).
 */
class StoreContactMessageRequest extends FormRequest
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly ConsultationFormTokenService $formTokenService,
    ) {
        parent::__construct();
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $limits = config('contact-form.validation', []);

        return [
            'name' => ['required', 'string', 'max:'.($limits['name_max'] ?? 150)],
            'whatsapp' => ['required', 'string', 'max:'.($limits['whatsapp_max'] ?? 30), 'regex:/^[0-9+\-\s]{8,20}$/'],
            'email' => ['nullable', 'string', 'email', 'max:'.($limits['email_max'] ?? 255)],
            'program' => ['required', 'string', Rule::in($this->activeProgramValues())],
            'message' => ['required', 'string', 'min:'.($limits['message_min'] ?? 10), 'max:'.($limits['message_max'] ?? 3000)],
            'consent' => ['accepted'],
            // Honeypot: a real visitor never fills this in.
            'website' => ['prohibited'],
            'form_token' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'program.in' => 'Program yang dipilih tidak valid atau sudah tidak tersedia.',
            'whatsapp.regex' => 'Gunakan format nomor WhatsApp yang valid, contoh: 0812xxxxxxx.',
        ];
    }

    /**
     * Active program option values from the CMS (about-contact →
     * contact-form → form.program_options) — the only source of truth,
     * never a second hardcoded list. Falls back to
     * config/about-contact-content.php only when the database section is
     * empty, exactly like every other CMS-backed page.
     *
     * @return array<int, string>
     */
    private function activeProgramValues(): array
    {
        $fallback = config('about-contact-content.sections.contact-form', []);
        $content = $this->contentService->getSectionContent('about-contact', 'contact-form', $fallback);
        $options = $content['form']['program_options'] ?? [];

        return collect($options)
            ->filter(fn ($option) => ($option['is_active'] ?? true) !== false && ($option['value'] ?? '') !== '')
            ->pluck('value')
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Timing-trap check — deliberately vague error message attached to a
     * key with no corresponding visible field, so a bot (or a curious
     * visitor reading page source) learns nothing about which specific
     * spam check failed.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $minSeconds = (int) config('contact-form.spam_protection.minimum_fill_seconds', 3);
            $maxAgeMinutes = (int) config('contact-form.spam_protection.maximum_form_age_minutes', 120);

            $elapsed = $this->formTokenService->secondsSinceIssued($this->input('form_token'));

            if ($elapsed === null || $elapsed < $minSeconds || $elapsed > ($maxAgeMinutes * 60)) {
                $validator->errors()->add('form', 'Permintaan tidak dapat diproses saat ini. Silakan muat ulang halaman dan coba lagi.');
            }
        });
    }
}
