{{-- Nomor WhatsApp resmi ($siteWhatsappUrl, dari SiteSettingsComposer) —
     tombol disembunyikan sepenuhnya selama admin belum mengisi nomor
     asli lewat Pengaturan Website, bukan diarahkan ke tujuan pengganti. --}}
@if ($siteWhatsappUrl ?? null)
    <a
        href="{{ $siteWhatsappUrl }}"
        target="_blank"
        rel="noopener noreferrer"
        class="ca-whatsapp-button"
        aria-label="Konsultasi melalui WhatsApp"
        title="Konsultasi Sekarang"
    >
        <span class="ca-whatsapp-button__icon" data-lucide="message-circle" aria-hidden="true"></span>
    </a>
@endif
