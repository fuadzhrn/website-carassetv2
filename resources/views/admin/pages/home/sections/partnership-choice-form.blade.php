<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi">
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="600" rows="3" />
</x-admin::form.field>

@php
    $programLabels = ['owner' => 'Mitra Owner', 'driver' => 'Mitra Driver'];
@endphp

@foreach ($programLabels as $programKey => $programLabel)
    @php $program = $content[$programKey] ?? []; @endphp
    <fieldset class="ca-admin-repeater-group">
        <legend class="ca-admin-cta-fields__legend">{{ $programLabel }}</legend>

        <x-admin::form.field name="content.{{ $programKey }}.eyebrow" label="Eyebrow Panel">
            <x-admin::form.input name="content[{{ $programKey }}][eyebrow]" error-key="content.{{ $programKey }}.eyebrow" :value="$program['eyebrow'] ?? ''" maxlength="80" />
        </x-admin::form.field>

        <x-admin::form.field name="content.{{ $programKey }}.title" label="Judul Panel" required>
            <x-admin::form.input name="content[{{ $programKey }}][title]" error-key="content.{{ $programKey }}.title" :value="$program['title'] ?? ''" maxlength="100" required />
        </x-admin::form.field>

        <x-admin::form.field name="content.{{ $programKey }}.description" label="Deskripsi Panel" required>
            <x-admin::form.textarea name="content[{{ $programKey }}][description]" error-key="content.{{ $programKey }}.description" :value="$program['description'] ?? ''" maxlength="600" rows="3" />
        </x-admin::form.field>

        <x-admin::media-picker
            :name="'content['.$programKey.'][image_media_id]'"
            label="Gambar Panel"
            :selected-media="$mediaById->get($program['image_media_id'] ?? null)"
            :media-items="$recentMedia"
            helper="Kosongkan untuk memakai gambar bawaan panel ini."
        />

        <x-admin::form.field name="content.{{ $programKey }}.image_alt" label="Alt Text Gambar">
            <x-admin::form.input name="content[{{ $programKey }}][image_alt]" error-key="content.{{ $programKey }}.image_alt" :value="$program['image_alt'] ?? ''" maxlength="255" />
        </x-admin::form.field>

        <fieldset class="ca-admin-repeater-group ca-admin-repeater-group--nested">
            <legend class="ca-admin-cta-fields__legend">Benefit (maks. 4 slot)</legend>

            @for ($i = 0; $i < 4; $i++)
                @php $benefit = $program['benefits'][$i] ?? []; @endphp
                <div class="ca-admin-repeater-row">
                    <x-admin::form.field name="content.{{ $programKey }}.benefits.{{ $i }}.text" label="Slot {{ $i + 1 }}">
                        <x-admin::form.input name="content[{{ $programKey }}][benefits][{{ $i }}][text]" error-key="content.{{ $programKey }}.benefits.{{ $i }}.text" :value="$benefit['text'] ?? ''" maxlength="180" />
                    </x-admin::form.field>
                    <x-admin::form.checkbox
                        name="content[{{ $programKey }}][benefits][{{ $i }}][is_active]"
                        error-key="content.{{ $programKey }}.benefits.{{ $i }}.is_active"
                        value="1"
                        :checked="(bool) ($benefit['is_active'] ?? false)"
                        label="Tampilkan slot ini"
                    />
                </div>
            @endfor
        </fieldset>

        @include('admin.pages.home.partials.cta-fields', [
            'ctaData' => $program['cta'] ?? [],
            'fieldName' => 'content['.$programKey.'][cta]',
            'errorKey' => 'content.'.$programKey.'.cta',
            'heading' => 'CTA '.$programLabel,
            'allowedRoutes' => $allowedRoutes,
            'allowedAnchors' => $allowedAnchors,
        ])
    </fieldset>
@endforeach
