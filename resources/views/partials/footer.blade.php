<footer class="ca-footer">
    <div class="ca-container ca-footer__grid">
        <div class="ca-footer__brand">
            @if (file_exists(public_path('assets/images/brand/logo-on-dark.png')))
                <img
                    src="{{ asset('assets/images/brand/logo-on-dark.png') }}"
                    alt="CarAsset"
                    class="ca-footer__logo"
                >
            @else
                {{-- Ganti dengan logo resmi CarAsset (public/assets/images/brand/logo-on-dark.png) --}}
                <span class="ca-footer__logo-fallback ca-card-title">CarAsset</span>
            @endif

            <p class="ca-footer__tagline">Mobil Bekerja. Aset Bertumbuh.</p>
            <p class="ca-footer__summary">
                CarAsset adalah platform pengelolaan kendaraan produktif yang membantu
                mitra memiliki aset dan mengelola operasionalnya secara profesional.
            </p>
        </div>

        <div class="ca-footer__column">
            <h3 class="ca-footer__heading">Navigasi</h3>
            <ul class="ca-footer__links ca-list-reset">
                <li><a href="{{ route('home') }}" class="ca-footer__link">Home</a></li>
                <li><a href="{{ route('business') }}" class="ca-footer__link">Bisnis CarAsset</a></li>
                <li><a href="{{ route('partnership') }}" class="ca-footer__link">Program Kemitraan</a></li>
                <li><a href="{{ route('simulation') }}" class="ca-footer__link">Simulasi & Perlindungan</a></li>
                <li><a href="{{ route('about-contact') }}" class="ca-footer__link">Tentang & Kontak</a></li>
            </ul>
        </div>

        <div class="ca-footer__column">
            <h3 class="ca-footer__heading">Program</h3>
            <ul class="ca-footer__links ca-list-reset">
                <li><a href="{{ route('partnership') }}#mitra-owner" class="ca-footer__link">Mitra Owner</a></li>
                <li><a href="{{ route('partnership') }}#mitra-driver" class="ca-footer__link">Mitra Driver</a></li>
                <li><a href="{{ route('business') }}#own-operate-grow" class="ca-footer__link">Own – Operate – Grow</a></li>
                <li><a href="{{ route('about-contact') }}#contact" class="ca-footer__link">Konsultasi</a></li>
            </ul>
        </div>

        <div class="ca-footer__column ca-footer__contact">
            <h3 class="ca-footer__heading">Kontak</h3>
            <ul class="ca-footer__links ca-list-reset">
                <li class="ca-footer__contact-item">
                    <span class="ca-footer__contact-icon" data-lucide="phone" aria-hidden="true"></span>
                    <span>WhatsApp: +123-456-7890</span>
                </li>
                <li class="ca-footer__contact-item">
                    <span class="ca-footer__contact-icon" data-lucide="mail" aria-hidden="true"></span>
                    <span>Email: <a href="mailto:hello@carasset.id" class="ca-footer__link">hello@carasset.id</a></span>
                </li>
                <li class="ca-footer__contact-item">
                    <span class="ca-footer__contact-icon" data-lucide="map-pin" aria-hidden="true"></span>
                    <span>Gajah Mada Tower, Lt. 19-01, Jl. Gajah Mada No.19-26, Jakarta Pusat 10130</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="ca-footer__bottom">
        <div class="ca-container ca-footer__bottom-inner">
            <p class="ca-footer__copyright">&copy; {{ date('Y') }} CarAsset. Seluruh hak dilindungi.</p>
            <p class="ca-footer__notice">Informasi legalitas dan kontak mengikuti ketentuan resmi perusahaan.</p>
        </div>
    </div>
</footer>
