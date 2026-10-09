<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>ClinicOne | Klinik Umum</title>
    <style>
        :root {
            color-scheme: light;
            font-family: "Instrument Sans", Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #263b59;
            background: #f3f7fd;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-width: 320px;
            min-height: 100vh;
            margin: 0;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
        }

        button {
            font: inherit;
        }

        .welcome-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f3f7fd;
        }

        main {
            display: flex;
            flex: 1;
            flex-direction: column;
        }

        .site-header {
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 clamp(24px, 5.5vw, 88px);
            background: #fff;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .brand-mark {
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            border-radius: 7px;
            color: #fff;
            background: #347cf0;
        }

        .brand-mark svg {
            width: 20px;
            height: 20px;
        }

        .brand-name {
            display: block;
            color: #263b59;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -.04em;
            line-height: 1.1;
        }

        .brand-caption {
            display: block;
            margin-top: 4px;
            color: #8092ad;
            font-size: 9px;
            line-height: 1;
        }

        .header-help {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #8092ad;
            font-size: 9px;
        }

        .header-help a {
            color: #347cf0;
            font-weight: 600;
        }

        .header-help svg {
            width: 14px;
            height: 14px;
            color: #347cf0;
        }

        .hero {
            min-height: 283px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(320px, .9fr);
            align-items: center;
            gap: 36px;
            padding: 11px clamp(24px, 5.5vw, 80px);
            background: #edf5ff;
        }

        .hero-copy {
            max-width: 560px;
        }

        .eyebrow {
            margin: 0 0 12px;
            color: #347cf0;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .035em;
            text-transform: uppercase;
        }

        .hero h1 {
            max-width: 520px;
            margin: 0;
            color: #263b59;
            font-size: clamp(28px, 3.2vw, 36px);
            font-weight: 700;
            letter-spacing: -.045em;
            line-height: 1.14;
        }

        .hero-description {
            max-width: 520px;
            margin: 14px 0 0;
            color: #70839e;
            font-size: 12px;
            line-height: 1.5;
        }

        .hero-hint {
            display: flex;
            align-items: center;
            gap: 7px;
            margin: 14px 0 0;
            color: #70839e;
            font-size: 10px;
        }

        .hero-hint svg {
            width: 14px;
            height: 14px;
            flex: 0 0 auto;
            color: #347cf0;
        }

        .hero-illustration {
            display: block;
            width: min(100%, 300px);
            max-height: 260px;
            justify-self: center;
            object-fit: contain;
        }

        .access-section {
            width: min(100%, 760px);
            display: flex;
            flex: 1;
            align-self: center;
            flex-direction: column;
            justify-content: center;
            padding: 26px 22px 25px;
        }

        .section-heading {
            margin-bottom: 18px;
            text-align: center;
        }

        .section-heading h2 {
            margin: 0;
            color: #263b59;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -.025em;
        }

        .section-heading p {
            margin: 6px 0 0;
            color: #8092ad;
            font-size: 10px;
        }

        .access-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .access-card {
            display: flex;
            min-width: 0;
            flex-direction: column;
            padding: 16px;
            border: 1px solid #e7edf6;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 4px 14px #29405f08;
        }

        .access-card-heading {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .access-icon {
            width: 34px;
            height: 34px;
            display: grid;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 9px;
            color: #347cf0;
            background: #eaf2ff;
        }

        .access-icon svg {
            width: 19px;
            height: 19px;
        }

        .access-card h3 {
            margin: 0;
            color: #263b59;
            font-size: 15px;
            font-weight: 650;
            letter-spacing: -.02em;
        }

        .access-card-caption {
            display: block;
            margin-top: 3px;
            color: #8092ad;
            font-size: 8px;
        }

        .access-description {
            min-height: 32px;
            margin: 12px 0 8px;
            color: #70839e;
            font-size: 10px;
            line-height: 1.5;
        }

        .access-benefits {
            display: grid;
            gap: 6px;
            margin: 0 0 12px;
            padding: 0;
            color: #70839e;
            font-size: 9px;
            list-style: none;
        }

        .access-benefits li {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .access-benefits svg {
            width: 16px;
            height: 16px;
            flex: 0 0 auto;
            color: #347cf0;
        }

        .access-button {
            min-height: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: auto;
            padding: 0 12px;
            border: 1px solid #347cf0;
            border-radius: 6px;
            color: #347cf0;
            background: #fff;
            font-size: 10px;
            font-weight: 600;
            transition: color 150ms ease, background 150ms ease;
        }

        .access-button:hover {
            color: #fff;
            background: #347cf0;
        }

        .access-button--primary {
            color: #fff;
            background: #347cf0;
        }

        .access-button--primary:hover {
            background: #286de0;
        }

        .access-button svg {
            width: 17px;
            height: 17px;
            flex: 0 0 auto;
        }

        .access-footnote {
            margin: 10px 0 0;
            color: #8092ad;
            font-size: 8px;
            text-align: center;
        }

        .access-footnote a {
            color: #347cf0;
            font-weight: 600;
        }

        .privacy-note {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 24px;
            border-bottom: 1px solid #edf1f6;
            color: #8092ad;
            background: #fff;
            font-size: 8px;
            text-align: center;
        }

        .privacy-note svg {
            width: 18px;
            height: 18px;
            flex: 0 0 auto;
            color: #347cf0;
        }

        .site-footer {
            min-height: 43px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 clamp(24px, 5.5vw, 88px);
            color: #8092ad;
            background: #fff;
            font-size: 8px;
        }

        .footer-links {
            display: flex;
            gap: 22px;
        }

        .footer-links a:hover {
            color: #347cf0;
        }

        @media (min-width: 1000px) {
            .hero {
                padding-right: max(calc((100vw - 1200px) / 2), 6vw);
                padding-left: max(calc((100vw - 1200px) / 2), 6vw);
            }
        }

        @media (max-width: 760px) {
            .hero {
                min-height: 0;
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 36px 28px 30px;
                text-align: center;
            }

            .hero-copy {
                margin: 0 auto;
            }

            .hero h1,
            .hero-description {
                margin-right: auto;
                margin-left: auto;
            }

            .hero-hint {
                justify-content: center;
            }

            .hero-illustration {
                width: min(60%, 360px);
                max-height: 250px;
            }

            .access-section {
                width: min(100%, 720px);
                flex: initial;
                padding: 32px 24px;
            }
        }

        @media (max-width: 620px) {
            .site-header {
                min-height: 64px;
                padding: 0 20px;
            }

            .header-help > span {
                display: none;
            }

            .hero {
                grid-template-columns: 1fr;
                gap: 12px;
                padding: 34px 24px 28px;
                text-align: center;
            }

            .hero-copy {
                margin: 0 auto;
            }

            .eyebrow {
                margin-bottom: 12px;
            }

            .hero h1 {
                margin: 0 auto;
                font-size: clamp(30px, 8vw, 38px);
            }

            .hero-description {
                margin: 14px auto 0;
                font-size: 14px;
            }

            .hero-hint {
                justify-content: center;
                margin-top: 14px;
                font-size: 12px;
            }

            .hero-illustration {
                width: min(78%, 300px);
                max-height: 220px;
            }

            .access-section {
                padding: 34px 20px;
            }

            .section-heading {
                margin-bottom: 20px;
            }

            .access-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .access-description {
                min-height: 0;
            }

            .access-card {
                padding: 20px;
            }

            .access-icon {
                width: 40px;
                height: 40px;
            }

            .access-card h3 {
                font-size: 17px;
            }

            .access-card-caption {
                font-size: 11px;
            }

            .access-description {
                margin-top: 14px;
                font-size: 13px;
            }

            .access-benefits {
                gap: 8px;
                font-size: 12px;
            }

            .access-button {
                min-height: 44px;
                font-size: 13px;
            }

            .access-footnote {
                font-size: 10px;
            }

            .privacy-note {
                padding: 12px 20px;
                font-size: 11px;
                line-height: 1.5;
            }

            .site-footer {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
                padding: 14px 20px;
                font-size: 10px;
            }

            .footer-links {
                flex-wrap: wrap;
                gap: 16px;
            }
        }

        @media (max-width: 370px) {
            .hero {
                padding-right: 16px;
                padding-left: 16px;
            }

            .access-section {
                padding-right: 14px;
                padding-left: 14px;
            }

            .access-card {
                padding: 16px;
            }

            .privacy-note {
                align-items: flex-start;
                gap: 8px;
                padding-right: 16px;
                padding-left: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-page">
        <header class="site-header">
            <a class="brand" href="{{ route('home') }}" aria-label="ClinicOne, halaman utama">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M9 4h6v5h5v6h-5v5H9v-5H4V9h5V4Z" fill="currentColor"/>
                    </svg>
                </span>
                <span>
                    <span class="brand-name">ClinicOne</span>
                    <span class="brand-caption">Klinik Umum</span>
                </span>
            </a>
            <div class="header-help">
                <span>Butuh bantuan?</span>
                <a href="tel:+628123456789">Hubungi kami</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8A8.5 8.5 0 0 1 8.7 3.9a8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z"/></svg>
            </div>
        </header>

        <main>
            <section class="hero" aria-labelledby="welcome-title">
                <div class="hero-copy">
                    <p class="eyebrow">Layanan Klinik ClinicOne</p>
                    <h1 id="welcome-title">Selamat datang<br>di ClinicOne</h1>
                    <p class="hero-description">Akses jadwal pemeriksaan dan riwayat kesehatan, atau kelola layanan klinik dalam satu tempat.</p>
                    <p class="hero-hint">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/><path d="M5 6v12"/></svg>
                        Mulai dengan memilih peran Anda di bawah.
                    </p>
                </div>
                <img class="hero-illustration" src="{{ asset('img/Doctor.png') }}" alt="Ilustrasi dokter dan kalender pemeriksaan">
            </section>

            <section class="access-section" aria-labelledby="access-heading">
                <div class="section-heading">
                    <h2 id="access-heading">Bagaimana Anda ingin masuk?</h2>
                    <p>Pilih akses yang sesuai untuk melanjutkan ke halaman masuk.</p>
                </div>

                <div class="access-grid">
                    <article class="access-card">
                        <div class="access-card-heading">
                            <span class="access-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="3.5"/>
                                    <path d="M5.5 20v-1.5a6.5 6.5 0 0 1 13 0V20"/>
                                </svg>
                            </span>
                            <span>
                                <h3>Saya Pasien</h3>
                                <span class="access-card-caption">Masuk dengan email dan kata sandi</span>
                            </span>
                        </div>
                        <p class="access-description">Akses layanan pemeriksaan dan informasi kesehatan Anda dengan mudah.</p>
                        <ul class="access-benefits">
                            <li><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 8 3 3 7-7"/></svg>Daftar pemeriksaan dan lihat jadwal</li>
                            <li><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 8 3 3 7-7"/></svg>Akses riwayat kesehatan Anda</li>
                        </ul>
                        <a class="access-button access-button--primary" href="{{ route('pasien.login') }}">
                            Masuk sebagai Pasien
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h15m-6-6 6 6-6 6"/></svg>
                        </a>
                        <p class="access-footnote">Belum punya akun? <a href="{{ route('pasien.daftar') }}">Daftar sekarang</a></p>
                    </article>

                    <article class="access-card">
                        <div class="access-card-heading">
                            <span class="access-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M7 4H5a2 2 0 0 0-2 2v2a7 7 0 0 0 7 7h1a7 7 0 0 0 7-7V6a2 2 0 0 0-2-2h-2v5h4"/>
                                    <path d="M11 15v1a4 4 0 0 0 4 4h2"/><circle cx="19" cy="20" r="2"/>
                                </svg>
                            </span>
                            <span>
                                <h3>Saya Dokter</h3>
                                <span class="access-card-caption">Masuk ke layanan klinik</span>
                            </span>
                        </div>
                        <p class="access-description">Masuk untuk mengelola layanan klinik, janji, dan jadwal pasien.</p>
                        <ul class="access-benefits">
                            <li><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 8 3 3 7-7"/></svg>Kelola janji dan jadwal pasien</li>
                            <li><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 8 3 3 7-7"/></svg>Akses layanan dokter/admin klinik</li>
                        </ul>
                        <a class="access-button" href="{{ route('dokter.login') }}">
                            Masuk sebagai Dokter
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h15m-6-6 6 6-6 6"/></svg>
                        </a>
                        <p class="access-footnote">Khusus dokter/admin klinik.</p>
                    </article>
                </div>
            </section>
        </main>

        <div class="privacy-note">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3m-4 5v2"/></svg>
            <span>Informasi medis Anda hanya dapat diakses oleh Anda dan tenaga kesehatan yang menangani pemeriksaan.</span>
        </div>

        <footer class="site-footer" id="footer">
            <span>&copy; {{ date('Y') }} ClinicOne. Kesehatan Anda, prioritas kami.</span>
            <nav class="footer-links" aria-label="Informasi hukum">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat &amp; Ketentuan</a>
            </nav>
        </footer>
    </div>
</body>
</html>
