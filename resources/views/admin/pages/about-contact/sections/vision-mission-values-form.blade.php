<p class="ca-admin-field__helper">
    Desain halaman saat ini tidak memiliki judul section gabungan — blok Visi dan blok Misi masing-masing memiliki label sendiri di bawah. Field di bawah ini tetap tersimpan untuk kelengkapan data.
</p>

<x-admin::form.field name="content.eyebrow" label="Eyebrow (tidak ditampilkan di publik)">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul (tidak ditampilkan di publik)" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi (tidak ditampilkan di publik)">
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="700" rows="2" />
</x-admin::form.field>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Vision</legend>

    <x-admin::form.field name="content.vision.label" label="Label">
        <x-admin::form.input name="content[vision][label]" error-key="content.vision.label" :value="$content['vision']['label'] ?? ''" maxlength="80" />
    </x-admin::form.field>

    <x-admin::form.field name="content.vision.direction" label="Arah Visi (opsional)">
        <x-admin::form.textarea name="content[vision][direction]" error-key="content.vision.direction" :value="$content['vision']['direction'] ?? ''" maxlength="400" rows="2" />
    </x-admin::form.field>

    <x-admin::form.field name="content.vision.statement" label="Redaksi Visi">
        <x-admin::form.textarea name="content[vision][statement]" error-key="content.vision.statement" :value="$content['vision']['statement'] ?? ''" maxlength="1000" rows="3" />
    </x-admin::form.field>

    <x-admin::cms.data-status
        name-prefix="content[vision]"
        error-key-prefix="content.vision"
        status-field-key="editorial_status"
        :value="$content['vision']['editorial_status'] ?? 'draft'"
        legend="Status Redaksi Visi"
        draft-label="Masih Dalam Penyusunan"
        confirmed-label="Telah Dikonfirmasi"
        :show-status-note="false"
    />

    <p class="ca-admin-field__helper">
        Status redaksi hanya menandai kesiapan konten untuk ditampilkan. Pastikan redaksi telah memperoleh persetujuan sebelum memilih "Telah Dikonfirmasi".
    </p>
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Mission</legend>

    <x-admin::form.field name="content.mission.label" label="Label">
        <x-admin::form.input name="content[mission][label]" error-key="content.mission.label" :value="$content['mission']['label'] ?? ''" maxlength="80" />
    </x-admin::form.field>

    <x-admin::form.field name="content.mission.intro" label="Intro (opsional)">
        <x-admin::form.textarea name="content[mission][intro]" error-key="content.mission.intro" :value="$content['mission']['intro'] ?? ''" maxlength="500" rows="2" />
    </x-admin::form.field>

    <div class="ca-admin-repeater-group" data-repeater-group>
        @for ($i = 0; $i < 8; $i++)
            <x-admin::cms.fixed-list-row
                :fields="[['key' => 'text', 'label' => 'Poin Misi '.($i + 1), 'type' => 'textarea', 'maxlength' => 500, 'rows' => 2]]"
                :values="$content['mission']['items'][$i] ?? []"
                :name-prefix="'content[mission][items]['.$i.']'"
                :error-key-prefix="'content.mission.items.'.$i"
                :active-checked="(bool) ($content['mission']['items'][$i]['is_active'] ?? false)"
                :item-key="$content['mission']['items'][$i]['item_key'] ?? 'mission-'.($i + 1)"
                :show-reorder="true"
                :row-index="$i"
                :row-count="8"
            />
        @endfor
    </div>

    <x-admin::cms.data-status
        name-prefix="content[mission]"
        error-key-prefix="content.mission"
        status-field-key="editorial_status"
        :value="$content['mission']['editorial_status'] ?? 'draft'"
        legend="Status Redaksi Misi"
        draft-label="Masih Dalam Penyusunan"
        confirmed-label="Telah Dikonfirmasi"
        :show-status-note="false"
    />

    <p class="ca-admin-field__helper">
        Status redaksi hanya menandai kesiapan konten untuk ditampilkan. Pastikan redaksi telah memperoleh persetujuan sebelum memilih "Telah Dikonfirmasi".
    </p>
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Values (4 nilai tetap)</legend>

    @foreach (['trust' => 'Trust', 'growth' => 'Growth', 'productive' => 'Productive', 'partnership' => 'Partnership'] as $valueKey => $valueTitle)
        @php $value = $content['values'][$valueKey] ?? []; @endphp

        <div class="ca-admin-repeater-row">
            <div class="ca-admin-field">
                <label class="ca-admin-field__label">Judul (terkunci)</label>
                <input type="text" class="ca-admin-field__control" value="{{ $valueTitle }}" disabled>
            </div>

            <x-admin::form.field :name="'content.values.'.$valueKey.'.description'" label="Deskripsi">
                <x-admin::form.textarea :name="'content[values]['.$valueKey.'][description]'" :error-key="'content.values.'.$valueKey.'.description'" :value="$value['description'] ?? ''" maxlength="500" rows="2" />
            </x-admin::form.field>

            <x-admin::form.checkbox
                :name="'content[values]['.$valueKey.'][is_active]'"
                :error-key="'content.values.'.$valueKey.'.is_active'"
                value="1"
                :checked="(bool) ($value['is_active'] ?? true)"
                label="Tampilkan nilai ini"
            />
        </div>
    @endforeach
</fieldset>
