<?php

namespace App\Http\Requests\Admin\ContactMessages;

use App\Models\ContactMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactMessageStatusRequest extends FormRequest
{
    /**
     * @var array<string, array<int, string>>
     */
    private const ALLOWED_TRANSITIONS = [
        ContactMessage::STATUS_NEW => [ContactMessage::STATUS_READ, ContactMessage::STATUS_COMPLETED, ContactMessage::STATUS_ARCHIVED],
        ContactMessage::STATUS_READ => [ContactMessage::STATUS_COMPLETED, ContactMessage::STATUS_ARCHIVED],
        ContactMessage::STATUS_COMPLETED => [ContactMessage::STATUS_READ, ContactMessage::STATUS_ARCHIVED],
        ContactMessage::STATUS_ARCHIVED => [ContactMessage::STATUS_READ],
    ];

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
            'status' => ['required', 'string', Rule::in(ContactMessage::statuses())],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            /** @var ContactMessage|null $message */
            $message = $this->route('contactMessage');
            $requestedStatus = $this->input('status');

            if (! $message || ! $requestedStatus) {
                return;
            }

            $allowed = self::ALLOWED_TRANSITIONS[$message->status] ?? [];

            if (! in_array($requestedStatus, $allowed, true)) {
                $validator->errors()->add('status', 'Perubahan status tidak diperbolehkan dari status saat ini.');
            }
        });
    }
}
