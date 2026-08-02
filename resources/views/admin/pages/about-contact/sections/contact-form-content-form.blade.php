@php
    $mapAddressReady = ! empty($globalContact['address']) && ($globalContact['site_data_status'] ?? 'draft') === 'confirmed';
@endphp

<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi">
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="900" rows="3" />
</x-admin::form.field>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Contact Panel</legend>

    <x-admin::form.field name="content.contact_panel.title" label="Judul Panel">
        <x-admin::form.input name="content[contact_panel][title]" error-key="content.contact_panel.title" :value="$content['contact_panel']['title'] ?? ''" maxlength="140" />
    </x-admin::form.field>

    <x-admin::form.field name="content.contact_panel.description" label="Deskripsi Panel">
        <x-admin::form.textarea name="content[contact_panel][description]" error-key="content.contact_panel.description" :value="$content['contact_panel']['description'] ?? ''" maxlength="700" rows="2" />
    </x-admin::form.field>
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Informasi Kontak Global (Read-Only)</legend>

    <dl class="ca-admin-global-contact">
        <div class="ca-admin-global-contact__row">
            <dt>WhatsApp</dt>
            <dd>{{ $globalContact['whatsapp'] ?: 'Belum Diisi' }}</dd>
        </div>
        <div class="ca-admin-global-contact__row">
            <dt>Email</dt>
            <dd>{{ $globalContact['email'] ?: 'Belum Diisi' }}</dd>
        </div>
        <div class="ca-admin-global-contact__row">
            <dt>Alamat</dt>
            <dd>{{ $globalContact['address'] ?: 'Belum Diisi' }}</dd>
        </div>
        <div class="ca-admin-global-contact__row">
            <dt>Jam Layanan</dt>
            <dd>{{ $globalContact['business_hours'] ?: 'Belum Diisi' }}</dd>
        </div>
        <div class="ca-admin-global-contact__row">
            <dt>Status Data Website</dt>
            <dd>{{ ($globalContact['site_data_status'] ?? 'draft') === 'confirmed' ? 'Telah Dikonfirmasi' : 'Masih Menunggu Konfirmasi' }}</dd>
        </div>
    </dl>

    <x-admin::button :href="route('admin.settings.index').'#contact'" variant="outline" size="sm" icon="settings">
        Kelola Informasi Kontak
    </x-admin::button>
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Form Content</legend>

    <input type="hidden" name="content[form][title]" value="{{ $content['form']['title'] ?? $content['title'] ?? '' }}">

    <x-admin::form.field name="content.form.description" label="Deskripsi Form (opsional)">
        <x-admin::form.textarea name="content[form][description]" error-key="content.form.description" :value="$content['form']['description'] ?? ''" maxlength="700" rows="2" />
    </x-admin::form.field>

    <x-admin::form.field name="content.form.submit_label" label="Label Tombol">
        <x-admin::form.input name="content[form][submit_label]" error-key="content.form.submit_label" :value="$content['form']['submit_label'] ?? ''" maxlength="60" />
    </x-admin::form.field>

    <x-admin::form.field name="content.form.microcopy" label="Microcopy">
        <x-admin::form.textarea name="content[form][microcopy]" error-key="content.form.microcopy" :value="$content['form']['microcopy'] ?? ''" maxlength="500" rows="2" />
    </x-admin::form.field>

    <x-admin::form.field
        name="content.form.consent_label"
        label="Redaksi Persetujuan (Consent)"
        helper="Wajib diisi agar form konsultasi publik dapat dikirim. Isi hanya berdasarkan redaksi yang sudah disetujui — jangan membuat ketentuan hukum baru."
    >
        <x-admin::form.textarea name="content[form][consent_label]" error-key="content.form.consent_label" :value="$content['form']['consent_label'] ?? ''" maxlength="500" rows="2" />
    </x-admin::form.field>
</fieldset>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Pilihan Program (maks. 6)</legend>

    @for ($i = 0; $i < 6; $i++)
        @php $option = $content['form']['program_options'][$i] ?? []; @endphp
        <div class="ca-admin-repeater-row" data-repeater-row>
            <input type="hidden" name="content[form][program_options][{{ $i }}][item_key]" value="{{ $option['item_key'] ?? 'program-'.($i + 1) }}">

            <div class="ca-admin-repeater-row__controls">
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="up" {{ $i === 0 ? 'disabled' : '' }} aria-label="Naikkan urutan pilihan ini">
                    <span data-lucide="arrow-up" aria-hidden="true"></span>
                </button>
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="down" {{ $i === 5 ? 'disabled' : '' }} aria-label="Turunkan urutan pilihan ini">
                    <span data-lucide="arrow-down" aria-hidden="true"></span>
                </button>
            </div>

            <x-admin::form.field :name="'content.form.program_options.'.$i.'.label'" label="Label">
                <x-admin::form.input :name="'content[form][program_options]['.$i.'][label]'" :error-key="'content.form.program_options.'.$i.'.label'" :value="$option['label'] ?? ''" maxlength="100" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.form.program_options.'.$i.'.value'" label="Value Internal (huruf/angka/dash saja)">
                <x-admin::form.input :name="'content[form][program_options]['.$i.'][value]'" :error-key="'content.form.program_options.'.$i.'.value'" :value="$option['value'] ?? ''" maxlength="80" data-program-value-input />
            </x-admin::form.field>

            <x-admin::form.checkbox
                :name="'content[form][program_options]['.$i.'][is_active]'"
                :error-key="'content.form.program_options.'.$i.'.is_active'"
                value="1"
                :checked="(bool) ($option['is_active'] ?? false)"
                label="Tampilkan pilihan ini"
            />
        </div>
    @endfor
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Map</legend>

    <x-admin::form.checkbox
        name="content[map][is_active]"
        error-key="content.map.is_active"
        value="1"
        :checked="(bool) ($content['map']['is_active'] ?? false)"
        label="Aktifkan peta"
    />

    <x-admin::form.field name="content.map.embed_url" label="URL Embed (hanya Google Maps /maps/embed, HTTPS)">
        <x-admin::form.input type="url" name="content[map][embed_url]" error-key="content.map.embed_url" :value="$content['map']['embed_url'] ?? ''" placeholder="https://www.google.com/maps/embed?..." />
    </x-admin::form.field>

    <x-admin::form.field name="content.map.title" label="Judul Map">
        <x-admin::form.input name="content[map][title]" error-key="content.map.title" :value="$content['map']['title'] ?? ''" maxlength="180" />
    </x-admin::form.field>

    <p class="ca-admin-field__helper">
        Status alamat global: <strong>{{ $mapAddressReady ? 'Siap ditampilkan' : 'Belum siap' }}</strong>.
        Map hanya akan ditampilkan setelah alamat dan status data website dikonfirmasi.
    </p>
</fieldset>
