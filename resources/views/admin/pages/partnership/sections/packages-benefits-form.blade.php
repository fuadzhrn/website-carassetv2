@php
    $packageLabels = [
        'one_unit' => '1 Unit',
        'five_units' => '5 Unit',
        'ten_units' => '10 Unit',
    ];
    $featuredPackage = $content['featured_package'] ?? '';
@endphp

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="200" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi" required>
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="400" rows="3" />
</x-admin::form.field>

<fieldset class="ca-admin-featured-package">
    <legend class="ca-admin-cta-fields__legend">Paket Unggulan (pilih salah satu)</legend>

    <label class="ca-admin-featured-package__option">
        <input type="radio" name="content[featured_package]" value="" @checked($featuredPackage === '')>
        Tidak ada paket unggulan
    </label>

    @foreach ($packageLabels as $packageKey => $packageLabel)
        <label class="ca-admin-featured-package__option">
            <input type="radio" name="content[featured_package]" value="{{ $packageKey }}" @checked($featuredPackage === $packageKey)>
            {{ $packageLabel }}
        </label>
    @endforeach
</fieldset>

@foreach ($packageLabels as $packageKey => $packageLabel)
    @php
        $package = $content['packages'][$packageKey] ?? [];
    @endphp

    <fieldset class="ca-admin-package-group">
        <legend class="ca-admin-cta-fields__legend">Paket {{ $packageLabel }}</legend>

        <x-admin::form.field :name="'content.packages.'.$packageKey.'.label'" label="Label Paket">
            <x-admin::form.input :name="'content[packages]['.$packageKey.'][label]'" :error-key="'content.packages.'.$packageKey.'.label'" :value="$package['label'] ?? ''" maxlength="60" />
        </x-admin::form.field>

        <x-admin::form.field :name="'content.packages.'.$packageKey.'.title'" label="Judul Unit (mis. &quot;1 Unit&quot;)">
            <x-admin::form.input :name="'content[packages]['.$packageKey.'][title]'" :error-key="'content.packages.'.$packageKey.'.title'" :value="$package['title'] ?? ''" maxlength="40" />
        </x-admin::form.field>

        <x-admin::form.field :name="'content.packages.'.$packageKey.'.description'" label="Deskripsi Paket">
            <x-admin::form.textarea :name="'content[packages]['.$packageKey.'][description]'" :error-key="'content.packages.'.$packageKey.'.description'" :value="$package['description'] ?? ''" maxlength="300" rows="2" />
        </x-admin::form.field>

        <div class="ca-admin-repeater-group" data-repeater-group>
            @for ($i = 0; $i < 3; $i++)
                <x-admin::cms.fixed-list-row
                    :fields="[['key' => 'text', 'label' => 'Benefit '.($i + 1), 'maxlength' => 150]]"
                    :values="$package['benefits'][$i] ?? []"
                    :name-prefix="'content[packages]['.$packageKey.'][benefits]['.$i.']'"
                    :error-key-prefix="'content.packages.'.$packageKey.'.benefits.'.$i"
                    :active-checked="(bool) ($package['benefits'][$i]['is_active'] ?? false)"
                    :item-key="$package['benefits'][$i]['item_key'] ?? $packageKey.'-benefit-'.($i + 1)"
                    :show-reorder="true"
                    :row-index="$i"
                    :row-count="3"
                />
            @endfor
        </div>

        <x-admin::cms.cta-fields
            :cta-data="$package['cta'] ?? []"
            :field-name="'content[packages]['.$packageKey.'][cta]'"
            :error-key="'content.packages.'.$packageKey.'.cta'"
            heading="CTA Paket"
            :allowed-routes="$allowedRoutes"
            :allowed-anchors="$allowedAnchors"
        />

        <x-admin::form.checkbox
            :name="'content[packages]['.$packageKey.'][is_active]'"
            :error-key="'content.packages.'.$packageKey.'.is_active'"
            value="1"
            :checked="(bool) ($package['is_active'] ?? true)"
            label="Tampilkan paket ini"
        />
    </fieldset>
@endforeach

<x-admin::form.field name="content.disclaimer" label="Catatan Kaki / Disclaimer">
    <x-admin::form.textarea name="content[disclaimer]" error-key="content.disclaimer" :value="$content['disclaimer'] ?? ''" maxlength="300" rows="2" />
</x-admin::form.field>

<p class="ca-admin-field__helper">
    Jumlah unit per paket (1/5/10) merupakan struktur tetap dan tidak dapat diubah dari sini.
</p>
