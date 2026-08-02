<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi">
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="700" rows="2" />
</x-admin::form.field>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Daftar FAQ (maks. 20, urutan dapat diubah)</legend>

    @for ($i = 0; $i < 20; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[
                ['key' => 'question', 'label' => 'Pertanyaan '.($i + 1), 'maxlength' => 300],
                ['key' => 'answer', 'label' => 'Jawaban', 'type' => 'textarea', 'maxlength' => 1500, 'rows' => 3],
            ]"
            :values="$content['items'][$i] ?? []"
            :name-prefix="'content[items]['.$i.']'"
            :error-key-prefix="'content.items.'.$i"
            :active-checked="(bool) ($content['items'][$i]['is_active'] ?? false)"
            :item-key="$content['items'][$i]['item_key'] ?? 'faq-'.($i + 1)"
            :show-reorder="true"
            :row-index="$i"
            :row-count="20"
        />
    @endfor
</fieldset>

<x-admin::form.field name="content.closing_note" label="Closing Note">
    <x-admin::form.textarea name="content[closing_note]" error-key="content.closing_note" :value="$content['closing_note'] ?? ''" maxlength="500" rows="2" />
</x-admin::form.field>
