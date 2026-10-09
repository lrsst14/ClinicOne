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

<<<<<<< HEAD
        <title>{{ config('app.name', 'ClinicOne') }} — Dashboard</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-slate-950 font-sans text-slate-100 antialiased">
        <main class="mx-auto flex min-h-screen w-full max-w-6xl flex-col gap-10 px-6 py-10 sm:px-10">
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-800 pb-6">
                <a href="{{ url('/') }}" class="text-xl font-semibold tracking-tight text-white">
                    Clinic<span class="text-sky-400">One</span>
                </a>
                <span class="rounded-full border border-slate-700 px-3 py-1 text-xs font-medium uppercase tracking-[0.18em] text-slate-400">
                    Dashboard
                </span>
            </header>

            <section
                data-registration-chart
                data-endpoint="{{ route('dashboard.registration-chart') }}"
                class="w-full max-w-4xl"
                aria-labelledby="registration-chart-title"
            >
                <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="mb-2 text-sm font-medium text-sky-400">Aktivitas akun</p>
                        <h1 id="registration-chart-title" class="text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                            Pendaftaran akun
                        </h1>
                        <p class="mt-2 text-sm text-slate-400">Jumlah akun baru setiap hari selama 7 hari terakhir.</p>
                    </div>
                    <div class="min-w-36 rounded-xl border border-slate-800 bg-slate-900/70 px-5 py-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Total 7 hari</p>
                        <p id="registration-total" class="mt-1 text-3xl font-semibold tabular-nums text-white" aria-live="polite">—</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-4 shadow-2xl shadow-black/10 sm:p-7">
                    <div class="mb-4 flex items-center gap-2">
                        <span class="relative flex size-2">
                            <span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-50"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-emerald-400"></span>
                        </span>
                        <p id="registration-chart-status" class="text-xs text-slate-400" role="status" aria-live="polite">
                            Memuat data pendaftaran...
                        </p>
                    </div>

                    <svg
                        class="h-auto w-full overflow-visible text-sky-400"
                        viewBox="0 0 700 260"
                        role="img"
                        aria-label="Grafik jumlah pendaftaran akun selama tujuh hari terakhir"
                        data-chart-svg
                    ></svg>
                </div>
            </section>
        </main>
    </body>
=======
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
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 clamp(24px, 6vw, 88px);
            background: #fff;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 7px;
            color: #fff;
            background: #347cf0;
        }

        .brand-mark svg {
            width: 23px;
            height: 23px;
        }

        .brand-name {
            display: block;
            color: #263b59;
            font-size: 19px;
            font-weight: 700;
            letter-spacing: -.04em;
            line-height: 1.1;
        }

        .brand-caption {
            display: block;
            margin-top: 4px;
            color: #8092ad;
            font-size: 11px;
            line-height: 1;
        }

        .header-help {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #8092ad;
            font-size: 13px;
        }

        .header-help a {
            color: #347cf0;
            font-weight: 600;
        }

        .header-help svg {
            width: 18px;
            height: 18px;
            color: #347cf0;
        }

        .hero {
            min-height: 360px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(320px, .9fr);
            align-items: center;
            gap: 36px;
            padding: 32px clamp(24px, 7vw, 104px);
            background: #edf5ff;
        }

        .hero-copy {
            max-width: 560px;
        }

        .eyebrow {
            margin: 0 0 16px;
            color: #347cf0;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .035em;
            text-transform: uppercase;
        }

        .hero h1 {
            max-width: 520px;
            margin: 0;
            color: #263b59;
            font-size: clamp(38px, 4.2vw, 56px);
            font-weight: 700;
            letter-spacing: -.045em;
            line-height: 1.14;
        }

        .hero-description {
            max-width: 520px;
            margin: 18px 0 0;
            color: #70839e;
            font-size: 16px;
            line-height: 1.65;
        }

        .hero-hint {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 18px 0 0;
            color: #70839e;
            font-size: 14px;
        }

        .hero-hint svg {
            width: 18px;
            height: 18px;
            flex: 0 0 auto;
            color: #347cf0;
        }

        .hero-illustration {
            display: block;
            width: min(100%, 420px);
            max-height: 320px;
            justify-self: center;
            object-fit: contain;
        }

        .access-section {
            width: min(100%, 1000px);
            display: flex;
            flex: 1;
            align-self: center;
            flex-direction: column;
            justify-content: center;
            padding: 42px 28px 46px;
        }

        .section-heading {
            margin-bottom: 24px;
            text-align: center;
        }

        .section-heading h2 {
            margin: 0;
            color: #263b59;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -.025em;
        }

        .section-heading p {
            margin: 8px 0 0;
            color: #8092ad;
            font-size: 14px;
        }

        .access-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .access-card {
            display: flex;
            min-width: 0;
            flex-direction: column;
            padding: 24px;
            border: 1px solid #e7edf6;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 4px 14px #29405f08;
        }

        .access-card-heading {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .access-icon {
            width: 48px;
            height: 48px;
            display: grid;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 12px;
            color: #347cf0;
            background: #eaf2ff;
        }

        .access-icon svg {
            width: 25px;
            height: 25px;
        }

        .access-card h3 {
            margin: 0;
            color: #263b59;
            font-size: 19px;
            font-weight: 650;
            letter-spacing: -.02em;
        }

        .access-card-caption {
            display: block;
            margin-top: 5px;
            color: #8092ad;
            font-size: 12px;
        }

        .access-description {
            min-height: 48px;
            margin: 16px 0 12px;
            color: #70839e;
            font-size: 14px;
            line-height: 1.6;
        }

        .access-benefits {
            display: grid;
            gap: 9px;
            margin: 0 0 18px;
            padding: 0;
            color: #70839e;
            font-size: 13px;
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
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: auto;
            padding: 0 16px;
            border: 1px solid #347cf0;
            border-radius: 8px;
            color: #347cf0;
            background: #fff;
            font-size: 14px;
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
            width: 20px;
            height: 20px;
            flex: 0 0 auto;
        }

        .access-footnote {
            margin: 13px 0 0;
            color: #8092ad;
            font-size: 12px;
            text-align: center;
        }

        .access-footnote a {
            color: #347cf0;
            font-weight: 600;
        }

        .privacy-note {
            min-height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 24px;
            border-bottom: 1px solid #edf1f6;
            color: #8092ad;
            background: #fff;
            font-size: 12px;
            text-align: center;
        }

        .privacy-note svg {
            width: 18px;
            height: 18px;
            flex: 0 0 auto;
            color: #347cf0;
        }

        .site-footer {
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 clamp(24px, 6vw, 88px);
            color: #8092ad;
            background: #fff;
            font-size: 11px;
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
                padding-right: max(calc((100vw - 1200px) / 2), 80px);
                padding-left: max(calc((100vw - 1200px) / 2), 80px);
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
                font-size: clamp(32px, 8vw, 42px);
            }

            .hero-description {
                margin: 14px auto 0;
                font-size: 15px;
            }

            .hero-hint {
                justify-content: center;
                margin-top: 14px;
                font-size: 13px;
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

            .privacy-note {
                line-height: 1.5;
            }

            .site-footer {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
                padding: 14px 20px;
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
                padding: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-page">
        <header class="site-header">
            <a class="brand" href="{{ url('/') }}" aria-label="ClinicOne, halaman utama">
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
        </header>

        <main>
            <section class="hero" aria-labelledby="welcome-title">
                <div class="hero-copy">
                    <p class="eyebrow">Layanan Klinik ClinicOne</p>
                    <h1 id="welcome-title">Selamat datang<br>di ClinicOne</h1>
                    <p class="hero-description">Akses jadwal pemeriksaan dan riwayat kesehatan, atau kelola layanan klinik dalam satu tempat.</p>
                    <p class="hero-hint">
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
                        <a class="access-button" href="{{ route('pasien.login') }}">
                            Masuk sebagai Dokter
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h15m-6-6 6 6-6 6"/></svg>
                        </a>
                        <p class="access-footnote">Khusus dokter/admin klinik.</p>
                    </article>
                </div>
            </section>
        </main>

        <footer class="site-footer" id="footer">
            <span>&copy; {{ date('Y') }} ClinicOne. Kesehatan Anda, prioritas kami.</span>
        </footer>
    </div>
</body>
>>>>>>> e026cd97d00fa4f4e3ba1970b764fd128d26def7
</html>
