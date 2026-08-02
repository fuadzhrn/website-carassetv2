<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi">
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="900" rows="3" />
</x-admin::form.field>

<x-admin::cms.data-status
    name-prefix="content[legal]"
    error-key-prefix="content.legal"
    status-field-key="data_status"
    :value="$content['legal']['data_status'] ?? 'draft'"
    legend="Status Data Legalitas"
    :status-note="$content['legal']['status_note'] ?? ''"
/>
<p class="ca-admin-field__helper">
    Status "Telah Dikonfirmasi" hanya menandai bahwa data siap ditampilkan. Sistem tidak melakukan verifikasi legalitas secara otomatis.
</p>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Informasi Legalitas</legend>

    <x-admin::form.field name="content.legal.entity_name" label="Nama Badan Usaha">
        <x-admin::form.input name="content[legal][entity_name]" error-key="content.legal.entity_name" :value="$content['legal']['entity_name'] ?? ''" maxlength="255" />
    </x-admin::form.field>

    <x-admin::form.field name="content.legal.registration_number" label="Nomor Legalitas">
        <x-admin::form.input name="content[legal][registration_number]" error-key="content.legal.registration_number" :value="$content['legal']['registration_number'] ?? ''" maxlength="255" />
    </x-admin::form.field>

    <x-admin::form.field name="content.legal.registered_address" label="Alamat Terdaftar">
        <x-admin::form.textarea name="content[legal][registered_address]" error-key="content.legal.registered_address" :value="$content['legal']['registered_address'] ?? ''" maxlength="1000" rows="2" />
    </x-admin::form.field>
</fieldset>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Dokumen Pendukung (maks. 10, gambar saja — JPG/PNG/WebP)</legend>

    @for ($i = 0; $i < 10; $i++)
        @php $document = $content['legal']['documents'][$i] ?? []; @endphp
        <div class="ca-admin-repeater-row" data-repeater-row>
            <input type="hidden" name="content[legal][documents][{{ $i }}][item_key]" value="{{ $document['item_key'] ?? 'document-'.($i + 1) }}">

            <div class="ca-admin-repeater-row__controls">
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="up" {{ $i === 0 ? 'disabled' : '' }} aria-label="Naikkan urutan dokumen ini">
                    <span data-lucide="arrow-up" aria-hidden="true"></span>
                </button>
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="down" {{ $i === 9 ? 'disabled' : '' }} aria-label="Turunkan urutan dokumen ini">
                    <span data-lucide="arrow-down" aria-hidden="true"></span>
                </button>
            </div>

            <x-admin::form.field :name="'content.legal.documents.'.$i.'.title'" label="Judul Dokumen">
                <x-admin::form.input :name="'content[legal][documents]['.$i.'][title]'" :error-key="'content.legal.documents.'.$i.'.title'" :value="$document['title'] ?? ''" maxlength="150" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.legal.documents.'.$i.'.description'" label="Deskripsi Dokumen">
                <x-admin::form.textarea :name="'content[legal][documents]['.$i.'][description]'" :error-key="'content.legal.documents.'.$i.'.description'" :value="$document['description'] ?? ''" maxlength="700" rows="2" />
            </x-admin::form.field>

            <x-admin::media-picker
                :name="'content[legal][documents]['.$i.'][document_media_id]'"
                label="Gambar Dokumen"
                :selected-media="$mediaById->get($document['document_media_id'] ?? null)"
                :media-items="$recentMedia"
            />

            <x-admin::form.field :name="'content.legal.documents.'.$i.'.document_alt'" label="Alt Text Dokumen">
                <x-admin::form.input :name="'content[legal][documents]['.$i.'][document_alt]'" :error-key="'content.legal.documents.'.$i.'.document_alt'" :value="$document['document_alt'] ?? ''" maxlength="255" />
            </x-admin::form.field>

            <x-admin::form.checkbox
                :name="'content[legal][documents]['.$i.'][is_active]'"
                :error-key="'content.legal.documents.'.$i.'.is_active'"
                value="1"
                :checked="(bool) ($document['is_active'] ?? false)"
                label="Tampilkan dokumen ini"
            />
        </div>
    @endfor
</fieldset>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Partner (maks. 12)</legend>

    @for ($i = 0; $i < 12; $i++)
        @php $partner = $content['partners'][$i] ?? []; @endphp
        <div class="ca-admin-repeater-row" data-repeater-row>
            <input type="hidden" name="content[partners][{{ $i }}][item_key]" value="{{ $partner['item_key'] ?? 'partner-'.($i + 1) }}">

            <div class="ca-admin-repeater-row__controls">
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="up" {{ $i === 0 ? 'disabled' : '' }} aria-label="Naikkan urutan partner ini">
                    <span data-lucide="arrow-up" aria-hidden="true"></span>
                </button>
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="down" {{ $i === 11 ? 'disabled' : '' }} aria-label="Turunkan urutan partner ini">
                    <span data-lucide="arrow-down" aria-hidden="true"></span>
                </button>
            </div>

            <x-admin::form.field :name="'content.partners.'.$i.'.name'" label="Nama Partner">
                <x-admin::form.input :name="'content[partners]['.$i.'][name]'" :error-key="'content.partners.'.$i.'.name'" :value="$partner['name'] ?? ''" maxlength="150" />
            </x-admin::form.field>

            <x-admin::media-picker
                :name="'content[partners]['.$i.'][logo_media_id]'"
                label="Logo Partner"
                :selected-media="$mediaById->get($partner['logo_media_id'] ?? null)"
                :media-items="$recentMedia"
            />

            <x-admin::form.field :name="'content.partners.'.$i.'.logo_alt'" label="Alt Text Logo">
                <x-admin::form.input :name="'content[partners]['.$i.'][logo_alt]'" :error-key="'content.partners.'.$i.'.logo_alt'" :value="$partner['logo_alt'] ?? ''" maxlength="255" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.partners.'.$i.'.description'" label="Deskripsi Partner">
                <x-admin::form.textarea :name="'content[partners]['.$i.'][description]'" :error-key="'content.partners.'.$i.'.description'" :value="$partner['description'] ?? ''" maxlength="600" rows="2" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.partners.'.$i.'.url'" label="URL Partner (opsional, http/https)">
                <x-admin::form.input type="url" :name="'content[partners]['.$i.'][url]'" :error-key="'content.partners.'.$i.'.url'" :value="$partner['url'] ?? ''" placeholder="https://..." />
            </x-admin::form.field>

            <x-admin::form.checkbox
                :name="'content[partners]['.$i.'][open_new_tab]'"
                :error-key="'content.partners.'.$i.'.open_new_tab'"
                value="1"
                :checked="(bool) ($partner['open_new_tab'] ?? true)"
                label="Buka di tab baru"
            />

            <x-admin::form.checkbox
                :name="'content[partners]['.$i.'][is_active]'"
                :error-key="'content.partners.'.$i.'.is_active'"
                value="1"
                :checked="(bool) ($partner['is_active'] ?? false)"
                label="Tampilkan partner ini"
            />
        </div>
    @endfor
</fieldset>

<x-admin::form.field name="content.partner_note" label="Catatan Partner">
    <x-admin::form.textarea name="content[partner_note]" error-key="content.partner_note" :value="$content['partner_note'] ?? ''" maxlength="500" rows="2" />
</x-admin::form.field>
