<x-admin::cms.section-header :content="$content" :description-max="800" />

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Growth Stages (maks. 4 slot, urutan tetap)</legend>

    @for ($i = 0; $i < 4; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[
                ['key' => 'label', 'label' => 'Label Tahap '.($i + 1), 'maxlength' => 50],
                ['key' => 'title', 'label' => 'Judul Tahap '.($i + 1), 'maxlength' => 100],
            ]"
            :values="$content['stages'][$i] ?? []"
            :name-prefix="'content[stages]['.$i.']'"
            :error-key-prefix="'content.stages.'.$i"
            :active-checked="(bool) ($content['stages'][$i]['is_active'] ?? false)"
        />
    @endfor
</fieldset>

<x-admin::cms.cta-fields
    :cta-data="$content['cta'] ?? []"
    field-name="content[cta]"
    error-key="content.cta"
    heading="CTA"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>
