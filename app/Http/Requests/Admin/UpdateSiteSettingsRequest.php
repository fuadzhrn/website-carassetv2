<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates POST data shaped as settings[group][field] => value — the
 * whitelist of valid group/field pairs comes entirely from
 * config('site-settings.groups'); nothing outside it is ever validated
 * or persisted (see SettingsService::setMany()).
 */
class UpdateSiteSettingsRequest extends FormRequest
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
        $rules = [
            'settings' => ['array'],
        ];

        foreach (config('site-settings.groups') as $groupKey => $groupData) {
            foreach ($groupData['fields'] as $fieldKey => $fieldData) {
                $rules["settings.{$groupKey}.{$fieldKey}"] = $fieldData['rules'];
            }
        }

        return $rules;
    }

    /**
     * Normalize submitted values before validation: trim strings, lowercase
     * emails, and turn empty strings into null so "cleared" fields save as
     * null rather than an empty string.
     */
    protected function prepareForValidation(): void
    {
        $settings = $this->input('settings', []);

        if (! is_array($settings)) {
            return;
        }

        foreach (config('site-settings.groups') as $groupKey => $groupData) {
            foreach ($groupData['fields'] as $fieldKey => $fieldData) {
                if (! array_key_exists($fieldKey, $settings[$groupKey] ?? [])) {
                    continue;
                }

                $value = $settings[$groupKey][$fieldKey];

                if (is_string($value)) {
                    $value = trim($value);
                    $value = $value === '' ? null : $value;
                }

                if ($value !== null && $fieldData['type'] === 'email') {
                    $value = strtolower($value);
                }

                if ($value !== null && $fieldData['type'] === 'media') {
                    $value = is_numeric($value) ? (int) $value : null;
                }

                $settings[$groupKey][$fieldKey] = $value;
            }
        }

        $this->merge(['settings' => $settings]);
    }
}
