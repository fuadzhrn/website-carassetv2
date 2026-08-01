@props(['checked' => true])

<x-admin::form.checkbox
    name="is_active"
    value="1"
    :checked="$checked"
    label="Tampilkan section pada halaman publik"
/>
