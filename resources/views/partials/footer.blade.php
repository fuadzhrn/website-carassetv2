<footer class="ca-footer">
    <div class="ca-container ca-footer__inner">
        <div class="ca-footer__brand">
            <span class="ca-footer__logo ca-card-title">CarAsset</span>
            <p class="ca-footer__tagline ca-body-text">Mobil Bekerja. Aset Bertumbuh.</p>
        </div>

        <nav class="ca-footer__nav" aria-label="Tautan footer">
            <ul>
                <li><a href="{{ route('home') }}" class="ca-nav-text">Home</a></li>
                <li><a href="{{ route('business') }}" class="ca-nav-text">Bisnis CarAsset</a></li>
                <li><a href="{{ route('partnership') }}" class="ca-nav-text">Program Kemitraan</a></li>
                <li><a href="{{ route('simulation') }}" class="ca-nav-text">Simulasi & Perlindungan</a></li>
                <li><a href="{{ route('about-contact') }}" class="ca-nav-text">Tentang & Kontak</a></li>
            </ul>
        </nav>

        <div class="ca-footer__legal ca-disclaimer-text">
            {{-- Alamat, nomor telepon, dan legalitas menunggu data resmi dari klien --}}
            <p>&copy; {{ now()->year }} CarAsset. Seluruh hak cipta dilindungi.</p>
        </div>
    </div>
</footer>
