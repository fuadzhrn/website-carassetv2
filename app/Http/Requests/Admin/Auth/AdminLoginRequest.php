<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'max:150'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Normalize the login identifier before validation.
     */
    protected function prepareForValidation(): void
    {
        $login = trim((string) $this->input('login', ''));

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $login = strtolower($login);
        }

        $this->merge(['login' => $login]);
    }

    /**
     * Whether the normalized login value looks like an email address.
     */
    public function loginIsEmail(): bool
    {
        return (bool) filter_var($this->input('login'), FILTER_VALIDATE_EMAIL);
    }
}
