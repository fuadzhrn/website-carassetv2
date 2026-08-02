@php
    $legalHelper = 'Isi hanya berdasarkan ketentuan resmi yang telah disetujui.';
@endphp

<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="200" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi" required>
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="400" rows="3" />
</x-admin::form.field>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Checkpoint (4 slot tetap, urutan terkunci)</legend>

    @for ($i = 0; $i < 4; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[['key' => 'title', 'label' => 'Checkpoint '.($i + 1), 'maxlength' => 40]]"
            :values="$content['checkpoints'][$i] ?? []"
            :name-prefix="'content[checkpoints]['.$i.']'"
            :error-key-prefix="'content.checkpoints.'.$i"
            :active-checked="(bool) ($content['checkpoints'][$i]['is_active'] ?? false)"
        />
    @endfor
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Dokumen dan Verifikasi</legend>
    <p class="ca-admin-field__helper">{{ $legalHelper }}</p>

    <x-admin::form.field name="content.verification.title" label="Judul Grup">
        <x-admin::form.input name="content[verification][title]" error-key="content.verification.title" :value="$content['verification']['title'] ?? ''" maxlength="100" />
    </x-admin::form.field>

    <div data-repeater-group>
        @for ($i = 0; $i < 4; $i++)
            <x-admin::cms.fixed-list-row
                :fields="[['key' => 'text', 'label' => 'Item '.($i + 1), 'maxlength' => 200]]"
                :values="$content['verification']['items'][$i] ?? []"
                :name-prefix="'content[verification][items]['.$i.']'"
                :error-key-prefix="'content.verification.items.'.$i"
                :active-checked="(bool) ($content['verification']['items'][$i]['is_active'] ?? false)"
                :item-key="$content['verification']['items'][$i]['item_key'] ?? 'verification-'.($i + 1)"
                :show-reorder="true"
                :row-index="$i"
                :row-count="4"
            />
        @endfor
    </div>

    <x-admin::form.checkbox
        name="content[verification][is_active]"
        error-key="content.verification.is_active"
        value="1"
        :checked="(bool) ($content['verification']['is_active'] ?? true)"
        label="Tampilkan grup ini"
    />
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Pembayaran dan Pelunasan</legend>
    <p class="ca-admin-field__helper">{{ $legalHelper }}</p>

    <x-admin::form.field name="content.payment.title" label="Judul Grup">
        <x-admin::form.input name="content[payment][title]" error-key="content.payment.title" :value="$content['payment']['title'] ?? ''" maxlength="100" />
    </x-admin::form.field>

    <div data-repeater-group>
        @for ($i = 0; $i < 3; $i++)
            <x-admin::cms.fixed-list-row
                :fields="[['key' => 'text', 'label' => 'Item '.($i + 1), 'maxlength' => 200]]"
                :values="$content['payment']['items'][$i] ?? []"
                :name-prefix="'content[payment][items]['.$i.']'"
                :error-key-prefix="'content.payment.items.'.$i"
                :active-checked="(bool) ($content['payment']['items'][$i]['is_active'] ?? false)"
                :item-key="$content['payment']['items'][$i]['item_key'] ?? 'payment-'.($i + 1)"
                :show-reorder="true"
                :row-index="$i"
                :row-count="3"
            />
        @endfor
    </div>

    <x-admin::form.checkbox
        name="content[payment][is_active]"
        error-key="content.payment.is_active"
        value="1"
        :checked="(bool) ($content['payment']['is_active'] ?? true)"
        label="Tampilkan grup ini"
    />
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Pembatalan Program</legend>
    <p class="ca-admin-field__helper">{{ $legalHelper }}</p>

    <x-admin::form.field name="content.cancellation.title" label="Judul Grup">
        <x-admin::form.input name="content[cancellation][title]" error-key="content.cancellation.title" :value="$content['cancellation']['title'] ?? ''" maxlength="100" />
    </x-admin::form.field>

    <x-admin::form.field name="content.cancellation.description" label="Isi Ketentuan" helper="Teks polos saja — format tebal/HTML tidak didukung.">
        <x-admin::form.textarea name="content[cancellation][description]" error-key="content.cancellation.description" :value="$content['cancellation']['description'] ?? ''" maxlength="400" rows="3" />
    </x-admin::form.field>

    <x-admin::form.checkbox
        name="content[cancellation][is_active]"
        error-key="content.cancellation.is_active"
        value="1"
        :checked="(bool) ($content['cancellation']['is_active'] ?? true)"
        label="Tampilkan grup ini"
    />
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Hak dan Kewajiban</legend>
    <p class="ca-admin-field__helper">{{ $legalHelper }}</p>

    <x-admin::form.field name="content.rights_obligations.title" label="Judul Grup">
        <x-admin::form.input name="content[rights_obligations][title]" error-key="content.rights_obligations.title" :value="$content['rights_obligations']['title'] ?? ''" maxlength="100" />
    </x-admin::form.field>

    <div data-repeater-group>
        @for ($i = 0; $i < 4; $i++)
            <x-admin::cms.fixed-list-row
                :fields="[
                    ['key' => 'label', 'label' => 'Label '.($i + 1), 'maxlength' => 60],
                    ['key' => 'text', 'label' => 'Isi', 'type' => 'textarea', 'maxlength' => 200, 'rows' => 2],
                ]"
                :values="$content['rights_obligations']['items'][$i] ?? []"
                :name-prefix="'content[rights_obligations][items]['.$i.']'"
                :error-key-prefix="'content.rights_obligations.items.'.$i"
                :active-checked="(bool) ($content['rights_obligations']['items'][$i]['is_active'] ?? false)"
                :item-key="$content['rights_obligations']['items'][$i]['item_key'] ?? 'rights-'.($i + 1)"
                :show-reorder="true"
                :row-index="$i"
                :row-count="4"
            />
        @endfor
    </div>

    <x-admin::form.checkbox
        name="content[rights_obligations][is_active]"
        error-key="content.rights_obligations.is_active"
        value="1"
        :checked="(bool) ($content['rights_obligations']['is_active'] ?? true)"
        label="Tampilkan grup ini"
    />
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Ketentuan Operasional</legend>
    <p class="ca-admin-field__helper">{{ $legalHelper }}</p>

    <x-admin::form.field name="content.operational_terms.title" label="Judul Grup">
        <x-admin::form.input name="content[operational_terms][title]" error-key="content.operational_terms.title" :value="$content['operational_terms']['title'] ?? ''" maxlength="100" />
    </x-admin::form.field>

    <div data-repeater-group>
        @for ($i = 0; $i < 5; $i++)
            <x-admin::cms.fixed-list-row
                :fields="[['key' => 'text', 'label' => 'Item '.($i + 1), 'maxlength' => 200]]"
                :values="$content['operational_terms']['items'][$i] ?? []"
                :name-prefix="'content[operational_terms][items]['.$i.']'"
                :error-key-prefix="'content.operational_terms.items.'.$i"
                :active-checked="(bool) ($content['operational_terms']['items'][$i]['is_active'] ?? false)"
                :item-key="$content['operational_terms']['items'][$i]['item_key'] ?? 'operational-'.($i + 1)"
                :show-reorder="true"
                :row-index="$i"
                :row-count="5"
            />
        @endfor
    </div>

    <x-admin::form.checkbox
        name="content[operational_terms][is_active]"
        error-key="content.operational_terms.is_active"
        value="1"
        :checked="(bool) ($content['operational_terms']['is_active'] ?? true)"
        label="Tampilkan grup ini"
    />
</fieldset>

<x-admin::form.field name="content.legal_note" label="Catatan Legal Tambahan (opsional)" :helper="$legalHelper">
    <x-admin::form.textarea name="content[legal_note]" error-key="content.legal_note" :value="$content['legal_note'] ?? ''" maxlength="500" rows="3" />
</x-admin::form.field>

<x-admin::form.field name="content.cta_title" label="Judul CTA Penutup">
    <x-admin::form.input name="content[cta_title]" error-key="content.cta_title" :value="$content['cta_title'] ?? ''" maxlength="200" />
</x-admin::form.field>

<x-admin::form.field name="content.cta_description" label="Deskripsi CTA Penutup">
    <x-admin::form.textarea name="content[cta_description]" error-key="content.cta_description" :value="$content['cta_description'] ?? ''" maxlength="400" rows="2" />
</x-admin::form.field>

<x-admin::cms.cta-fields
    :cta-data="$content['primary_cta'] ?? []"
    field-name="content[primary_cta]"
    error-key="content.primary_cta"
    heading="CTA Utama"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>

<x-admin::cms.cta-fields
    :cta-data="$content['secondary_cta'] ?? []"
    field-name="content[secondary_cta]"
    error-key="content.secondary_cta"
    heading="CTA Sekunder"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>
