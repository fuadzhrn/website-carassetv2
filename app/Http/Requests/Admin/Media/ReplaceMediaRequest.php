<?php

namespace App\Http\Requests\Admin\Media;

use Illuminate\Foundation\Http\FormRequest;

class ReplaceMediaRequest extends FormRequest
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
            'file' => [
                'required',
                'file',
                'image',
                'mimes:'.implode(',', config('media.allowed_mimes')),
                'mimetypes:'.implode(',', config('media.allowed_mime_types')),
                'max:'.config('media.max_size_kb'),
                'dimensions:max_width='.config('media.max_width').',max_height='.config('media.max_height'),
            ],
        ];
    }
}
