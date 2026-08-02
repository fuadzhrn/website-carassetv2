<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreContactMessageRequest;
use App\Services\ContactMessageService;
use Illuminate\Http\RedirectResponse;

class ContactFormController extends Controller
{
    public function __construct(private readonly ContactMessageService $contactMessageService)
    {
    }

    /**
     * Store one consultation request. Spam/rate-limit checks already
     * happened before this method runs (throttle:contact-form middleware,
     * honeypot + timing-trap inside StoreContactMessageRequest) — this
     * method only normalizes and persists already-validated data. Never
     * sends email, never opens WhatsApp, never logs message content.
     */
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $data = $this->normalize($request->validated());

        $this->contactMessageService->create($data, $request);

        return redirect(route('about-contact').'#contact')
            ->with('success', 'Terima kasih. Permintaan konsultasi Anda telah diterima dan akan ditinjau oleh tim CarAsset.');
    }

    /**
     * Pre-save normalization — never mass-assigns request()->all(),
     * operates only on the already-validated subset.
     *
     * @param array<string, mixed> $validated
     * @return array<string, mixed>
     */
    private function normalize(array $validated): array
    {
        $name = $this->collapseWhitespace($this->stripControlCharacters($validated['name']));
        $whatsapp = $this->collapseWhitespace($this->stripControlCharacters($validated['whatsapp']));
        $email = isset($validated['email']) && trim((string) $validated['email']) !== ''
            ? strtolower(trim($validated['email']))
            : null;
        $message = $this->stripControlCharacters(str_replace("\r\n", "\n", trim($validated['message'])));

        return [
            'name' => $name,
            'whatsapp' => $whatsapp,
            'email' => $email,
            'program' => $validated['program'],
            'message' => $message,
        ];
    }

    private function collapseWhitespace(string $value): string
    {
        return trim(preg_replace('/\s+/', ' ', $value));
    }

    /**
     * Strips non-printable control characters while preserving newlines
     * (used for the message field, which is otherwise left as plain text
     * — never converted to/from HTML).
     */
    private function stripControlCharacters(string $value): string
    {
        return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? $value;
    }
}
