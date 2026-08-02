<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required helper="Gunakan baris baru untuk memisahkan dua baris judul, sesuai tampilan publik.">
    <x-admin::form.textarea name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="200" rows="2" />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi" required>
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="500" rows="3" />
</x-admin::form.field>

@foreach (['owner' => 'Jalur Mitra Owner', 'driver' => 'Jalur Mitra Driver'] as $pathKey => $pathLabel)
    <fieldset class="ca-admin-repeater-group">
        <legend class="ca-admin-cta-fields__legend">{{ $pathLabel }}</legend>

        <x-admin::form.field :name="'content.'.$pathKey.'.label'" label="Label Navigasi Sticky">
            <x-admin::form.input :name="'content['.$pathKey.'][label]'" :error-key="'content.'.$pathKey.'.label'" :value="$content[$pathKey]['label'] ?? ''" maxlength="60" />
        </x-admin::form.field>

        <x-admin::form.field :name="'content.'.$pathKey.'.title'" label="Judul Kartu" required>
            <x-admin::form.input :name="'content['.$pathKey.'][title]'" :error-key="'content.'.$pathKey.'.title'" :value="$content[$pathKey]['title'] ?? ''" maxlength="100" required />
        </x-admin::form.field>

        <x-admin::form.field :name="'content.'.$pathKey.'.description'" label="Deskripsi Kartu" required>
            <x-admin::form.textarea :name="'content['.$pathKey.'][description]'" :error-key="'content.'.$pathKey.'.description'" :value="$content[$pathKey]['description'] ?? ''" maxlength="300" rows="3" />
        </x-admin::form.field>

        <x-admin::form.field :name="'content.'.$pathKey.'.cta_label'" label="Teks Tautan">
            <x-admin::form.input :name="'content['.$pathKey.'][cta_label]'" :error-key="'content.'.$pathKey.'.cta_label'" :value="$content[$pathKey]['cta_label'] ?? ''" maxlength="60" />
        </x-admin::form.field>

        <x-admin::form.checkbox
            :name="'content['.$pathKey.'][is_active]'"
            :error-key="'content.'.$pathKey.'.is_active'"
            value="1"
            :checked="(bool) ($content[$pathKey]['is_active'] ?? true)"
            label="Tampilkan jalur ini"
        />
    </fieldset>
@endforeach

<p class="ca-admin-field__helper">
    Tautan navigasi (menuju #mitra-owner / #mitra-driver) mengikuti struktur halaman dan tidak dapat diubah dari sini.
</p>
