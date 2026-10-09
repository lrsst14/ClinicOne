<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f4f8fd">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Pendaftaran Pemeriksaan | ClinicOne</title>
    <style>
        :root {
            color-scheme: light;
            font-family: "Instrument Sans", Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #29405f;
            background: #f4f8fd;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
        }
        * { box-sizing: border-box; }
        body { min-width: 320px; min-height: 100vh; margin: 0; }
        a { color: inherit; text-decoration: none; }
        button, input, textarea { font: inherit; }

        .app { display: grid; min-height: 100vh; grid-template-columns: 220px minmax(0, 1fr); }
        .sidebar { position: sticky; top: 0; display: flex; height: 100vh; flex-direction: column; padding: 20px 10px 12px; border-right: 1px solid #e6edf6; background: #fff; }
        .brand { display: inline-flex; align-items: center; gap: 8px; padding: 0 6px; color: #263b59; }
        .brand-mark { display: grid; width: 25px; height: 25px; flex: 0 0 auto; place-items: center; border-radius: 6px; color: #fff; background: #347cf0; }
        .brand-mark svg { width: 17px; height: 17px; }
        .brand-name { display: block; font-size: 18.8px; font-weight: 700; letter-spacing: -.04em; line-height: 1.1; }
        .brand-caption { display: block; margin-top: 3px; color: #8092ad; font-size: 11px; }
        .nav-label { margin: 28px 0 8px; color: #96a4b8; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .nav-list { display: grid; gap: 5px; }
        .nav-link { display: flex; min-height: 34px; align-items: center; gap: 9px; padding: 0 9px; border-radius: 6px; color: #697e9b; font-size: 11.3px; transition: color 150ms ease, background 150ms ease; }
        .nav-link:hover, .nav-link.active { color: #347cf0; background: #eaf2ff; }
        .nav-link.active { font-weight: 600; }
        .nav-link svg { width: 14px; height: 14px; flex: 0 0 auto; }
        .sidebar-bottom { display: grid; gap: 12px; margin-top: auto; }
        .clinic-status { padding: 10px 9px; border-radius: 7px; background: #f3f7fd; }
        .clinic-status-title { display: flex; align-items: center; gap: 5px; color: #425a79; font-size: 11px; font-weight: 600; }
        .clinic-status-title svg { width: 11px; height: 11px; color: #347cf0; }
        .clinic-status p { margin: 5px 0 0; color: #8293ad; font-size: 11px; }
        .logout-form { margin: 0; }
        .logout { display: flex; align-items: center; gap: 7px; padding: 0 9px; border: 0; color: #8293ad; background: transparent; font: inherit; font-size: 11.3px; text-align: left; cursor: pointer; }
        .logout svg { width: 13px; height: 13px; }

        .main { display: flex; min-width: 0; min-height: 100vh; flex-direction: column; }
        .topbar { display: flex; min-height: 56px; align-items: center; justify-content: flex-start; gap: 12px; padding: 0 20px 0 26px; border-bottom: 1px solid #e6edf6; background: #fff; }
        .breadcrumbs, .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .breadcrumbs { color: #8293ad; font-size: 11.3px; white-space: nowrap; }
        .breadcrumbs svg { width: 11px; height: 11px; }
        .breadcrumbs strong { color: #29405f; font-weight: 500; }
        .topbar-actions { gap: 13px; margin-left: auto; }
        .topbar-date { color: #8293ad; font-size: 11px; white-space: nowrap; }
        .divider { width: 1px; height: 25px; background: #e6edf6; }
        .user-menu { display: flex; align-items: center; gap: 8px; border: 0; background: transparent; text-align: left; }
        .initials { display: grid; width: 27px; height: 27px; place-items: center; border-radius: 50%; color: #347cf0; background: #eaf2ff; font-size: 11.3px; font-weight: 600; }
        .user-name { display: block; color: #29405f; font-size: 11px; font-weight: 600; }
        .user-id { display: block; margin-top: 2px; color: #8293ad; font-size: 11px; }

        .content { width: min(100%, 1300px); flex: 1; margin: 0 auto; padding: 24px 20px 12px 26px; }
        .welcome-row { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 17px; }
        .welcome-heading h1 { margin: 0; color: #29405f; font-size: clamp(25px, 2vw, 31.3px); font-weight: 700; letter-spacing: -.04em; line-height: 1.2; }
        .welcome-heading p { margin: 5px 0 0; color: #8293ad; font-size: 12.5px; }
        .success { display: flex; align-items: center; gap: 9px; margin-bottom: 16px; padding: 11px 13px; border: 1px solid #e0f3ec; border-radius: 7px; color: #218c72; background: #eaf8f2; }
        .success > svg { width: 16px; height: 16px; flex: 0 0 auto; }
        .success-copy { min-width: 0; }
        .success-copy strong { display: block; font-size: 11.3px; }
        .success-copy span { display: block; margin-top: 3px; font-size: 11px; line-height: 1.45; }
        .booking-code { margin-left: auto; font-size: 11px; font-weight: 600; white-space: nowrap; }
        .columns { display: grid; grid-template-columns: minmax(0, 1.9fr) minmax(220px, .9fr); align-items: start; gap: 16px; }
        .card { min-width: 0; padding: 16px; border: 1px solid #e6edf6; border-radius: 9px; background: #fff; box-shadow: 0 3px 10px #29405f05; }
        .card-title { margin: 0; color: #29405f; font-size: 16.3px; font-weight: 650; }
        .card-description { margin: 5px 0 13px; color: #8293ad; font-size: 11px; }
        .section-label { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin: 0 0 9px; color: #425a79; font-size: 11.3px; font-weight: 650; }
        .badge { padding: 4px 8px; border-radius: 999px; color: #347cf0; background: #eaf2ff; font-size: 11px; font-weight: 600; white-space: nowrap; }
        .badge.success-badge { color: #218c72; background: #eaf8f2; }
        .patient-grid, .visit-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
        .info label { display: block; margin-bottom: 5px; color: #425a79; font-size: 11px; font-weight: 550; }
        .value { display: flex; min-height: 32px; align-items: center; overflow: hidden; padding: 0 9px; border: 1px solid #e8eef6; border-radius: 6px; color: #8293ad; background: #f9fbfe; font-size: 11px; text-overflow: ellipsis; white-space: nowrap; }
        .separator { height: 1px; margin: 12px 0; border: 0; background: #edf1f6; }
        .doctor { display: flex; min-height: 54px; align-items: center; gap: 9px; margin-bottom: 11px; padding: 7px 9px; border-radius: 7px; background: #f8fafd; }
        .doctor img { width: 37px; height: 37px; flex: 0 0 auto; border: 1px solid #edf1f6; border-radius: 6px; background: #edf5ff; object-fit: cover; object-position: center 25%; }
        .doctor-name { display: block; color: #29405f; font-size: 11.3px; font-weight: 650; }
        .doctor-role { display: block; margin-top: 3px; color: #8293ad; font-size: 11px; }
        .doctor .badge { margin-left: auto; }
        .field { display: flex; width: 100%; min-height: 32px; align-items: center; justify-content: space-between; gap: 8px; padding: 0 9px; border: 1px solid #e8eef6; border-radius: 6px; color: #8293ad; background: #f9fbfe; font-size: 11px; }
        .field svg { width: 13px; height: 13px; flex: 0 0 auto; }
        textarea.field { min-height: 58px; align-items: flex-start; padding-top: 8px; line-height: 1.5; resize: vertical; }
        .hint { margin: 5px 0 0; color: #8293ad; font-size: 11px; }
        .full-width { grid-column: 1 / -1; }
        .form-footer { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 12px; }
        .form-note { margin: 0; color: #8293ad; font-size: 11px; }
        .primary-button { display: inline-flex; min-height: 35px; flex: 0 0 auto; align-items: center; justify-content: center; gap: 7px; padding: 0 14px; border: 1px solid #347cf0; border-radius: 6px; color: #fff; background: #347cf0; box-shadow: 0 2px 5px #347cf022; font-size: 11.3px; font-weight: 600; transition: background 150ms ease; }
        .primary-button:hover { background: #286de0; }
        .primary-button svg { width: 13px; height: 13px; }

        .side-stack { display: grid; gap: 13px; }
        .side-card { padding: 15px; }
        .side-card .card-title { margin-bottom: 12px; }
        .summary-list { display: grid; gap: 10px; margin: 12px 0; }
        .summary-row { display: flex; min-width: 0; align-items: center; gap: 8px; }
        .summary-icon { display: grid; width: 26px; height: 26px; flex: 0 0 auto; place-items: center; border-radius: 6px; color: #347cf0; background: #eaf2ff; }
        .summary-icon svg { width: 13px; height: 13px; }
        .summary-label { display: block; color: #8293ad; font-size: 11px; }
        .summary-value { display: block; margin-top: 3px; color: #425a79; font-size: 11px; font-weight: 550; line-height: 1.35; }
        .queue { padding: 10px; border-radius: 7px; color: #347cf0; background: #eaf2ff; text-align: center; }
        .queue-label { display: block; font-size: 11px; font-weight: 600; }
        .queue-number { display: block; margin-top: 3px; font-size: 28.8px; font-weight: 750; letter-spacing: .04em; line-height: 1.05; }
        .queue-code { display: block; margin-top: 4px; color: #8293ad; font-size: 11px; }
        .price { display: flex; justify-content: space-between; gap: 10px; margin: 11px 0; color: #8293ad; font-size: 11px; }
        .price strong { color: #425a79; font-size: 11.3px; }
        .payment-note, .arrival-copy { margin: 0; color: #8293ad; font-size: 11px; line-height: 1.5; }
        .download { display: inline-flex; width: 100%; min-height: 31px; align-items: center; justify-content: center; gap: 6px; margin-top: 11px; border: 1px solid #e6edf6; border-radius: 6px; color: #347cf0; background: #fff; font-size: 11px; font-weight: 600; }
        .download svg { width: 13px; height: 13px; }
        .arrival-title { margin: 0 0 7px; color: #29405f; font-size: 13.8px; font-weight: 650; }
        .arrival-actions { display: flex; justify-content: space-between; gap: 10px; margin-top: 10px; font-size: 11px; }
        .arrival-actions a:first-child { color: #347cf0; font-weight: 600; }
        .arrival-actions a:last-child { color: #8293ad; }
        .footer { display: flex; min-height: 30px; align-items: center; justify-content: space-between; gap: 15px; color: #8293ad; font-size: 11px; }
        .footer-links { display: flex; gap: 9px; }

        .mobile-menu-toggle { display: grid; width: 34px; height: 34px; flex: 0 0 auto; place-items: center; border: 1px solid #e6edf6; border-radius: 7px; color: #425a79; background: #fff; cursor: pointer; }
        .mobile-menu-toggle:hover { border-color: #b9d2ff; color: #347cf0; background: #f8faff; }
        .mobile-menu-toggle svg { width: 18px; height: 18px; }
        .sidebar-backdrop { display: none; }
        body.sidebar-open { overflow: hidden; }

        @media (min-width: 681px) {
            .app.sidebar-collapsed { grid-template-columns: minmax(0, 1fr); }
            .app.sidebar-collapsed > .sidebar { display: none; }
        }

        @media (min-width: 1500px) {
            .app { grid-template-columns: 230px minmax(0, 1fr); }
            .sidebar { padding-right: 14px; padding-left: 14px; }
            .topbar { min-height: 64px; padding-right: 30px; padding-left: 36px; }
            .content { padding: 34px 30px 16px 36px; }
            .card { padding: 20px; }
        }
        @media (max-width: 900px) {
            .app { grid-template-columns: 150px minmax(0, 1fr); }
            .topbar { padding-right: 14px; padding-left: 18px; }
            .content { padding-right: 14px; padding-left: 18px; }
            .columns { grid-template-columns: minmax(0, 1fr) 220px; gap: 11px; }
            .card { padding: 13px; }
        }
        @media (max-width: 680px) {
            .app { grid-template-columns: minmax(0, 1fr); }
            .sidebar { position: fixed; z-index: 30; inset: 0 auto 0 0; width: min(82vw, 280px); max-width: calc(100vw - 48px); min-width: 0; height: 100vh; height: 100dvh; padding: 20px 12px 14px; overflow-y: auto; border-right: 1px solid #e6edf6; border-bottom: 0; box-shadow: 10px 0 30px #29405f14; transform: translateX(-100%); visibility: hidden; transition: transform 180ms ease, visibility 180ms ease; }
            .app.sidebar-open .sidebar { transform: translateX(0); visibility: visible; }
            .sidebar-backdrop { position: fixed; z-index: 29; inset: 0; display: none; width: 100%; border: 0; padding: 0; background: #1d2d45a3; }
            .app.sidebar-open .sidebar-backdrop { display: block; }
            .nav-list { display: grid; width: 100%; min-width: 0; gap: 5px; margin-top: 0; overflow: visible; }
            .nav-link { min-height: 38px; padding: 0 9px; font-size: 12.5px; }
            .sidebar-bottom { margin-top: auto; }
            .topbar { min-height: 48px; justify-content: flex-start; gap: 9px; padding: 0 14px; }
            .breadcrumbs { min-width: 0; overflow: hidden; text-overflow: ellipsis; }
            .topbar-date, .user-id, .divider { display: none; }
            .topbar-actions { flex: 0 0 auto; gap: 8px; margin-left: auto; }
            .content { padding: 19px 14px 10px; }
            .welcome-row { align-items: flex-start; }
            .welcome-heading p { max-width: 260px; line-height: 1.5; }
            .primary-button { min-height: 33px; padding: 0 9px; font-size: 11px; }
            .columns { grid-template-columns: 1fr; }
            .side-stack { grid-template-columns: repeat(2, minmax(0, 1fr)); align-items: start; }
        }
        @media (max-width: 430px) {
            .welcome-row { flex-direction: column; align-items: stretch; gap: 12px; }
            .primary-button { align-self: flex-start; padding: 0 12px; font-size: 11.3px; }
            .patient-grid, .visit-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: auto; }
            .side-stack { grid-template-columns: 1fr; }
            .success { align-items: flex-start; }
            .booking-code { align-self: center; }
            .form-footer { align-items: flex-start; flex-direction: column; }
            .footer { padding: 7px 0; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/clinicone-interface-scale.css') }}">
</head>
<body>
    <div class="app">
        <aside class="sidebar" id="patient-sidebar">
            <a class="brand" href="{{ route('pasien.dashboard') }}" aria-label="ClinicOne, beranda pasien">
                <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M9 4h6v5h5v6h-5v5H9v-5H4V9h5V4Z" fill="currentColor"/></svg></span>
                <span><span class="brand-name">ClinicOne</span><span class="brand-caption">Klinik Umum</span></span>
            </a>
            <p class="nav-label">Menu pasien</p>
            <nav class="nav-list" aria-label="Menu pasien">
                <a class="nav-link" href="{{ route('pasien.dashboard') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><rect x="14" y="14" width="6" height="6" rx="1"/></svg>Beranda</a>
                <a class="nav-link active" href="{{ route('pasien.pendaftaran') }}" aria-current="page"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="6" width="16" height="14" rx="2"/><path d="M8 3v6m8-6v6M4 11h16M12 14v5m-2.5-2.5h5"/></svg>Pendaftaran</a>
                <a class="nav-link" href="{{ route('pasien.jadwal') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16"/></svg>Cek Jadwal Dokter</a>
                <a class="nav-link" href="{{ route('pasien.riwayat') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5h6v3H9zM9 12h6m-6 4h6"/></svg>Riwayat Pemeriksaan</a>
                <a class="nav-link" href="{{ route('pasien.profil-dokter') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 4H5a2 2 0 0 0-2 2v2a7 7 0 0 0 7 7h1a7 7 0 0 0 7-7V6a2 2 0 0 0-2-2h-2v5h4"/><path d="M11 15v1a4 4 0 0 0 4 4h2"/><circle cx="19" cy="20" r="2"/></svg>Profil Dokter</a>
            </nav>
            <div class="sidebar-bottom">
                <div class="clinic-status">
                    <div class="clinic-status-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 20h18M5 20V6h9v14m0-9h5v9M8 9h2m-2 4h2m-2 4h2m7-1h.01"/></svg>Klinik siap melayani</div>
                    <p>Jam praktik: 08.00 - 12.00</p>
                </div>
                <form class="logout-form" action="{{ route('pasien.logout') }}" method="POST">
                    @csrf
                    <button class="logout" type="submit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 17l5-5-5-5m5 5H3"/><path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/></svg>Logout</button>
                </form>
            </div>
        </aside>
        <div class="sidebar-backdrop" aria-hidden="true"></div>

        <div class="main">
            <header class="topbar">
                <button class="mobile-menu-toggle" type="button" aria-label="Buka menu pasien" aria-controls="patient-sidebar" aria-expanded="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <nav class="breadcrumbs" aria-label="Breadcrumb"><span>Halaman pasien</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg><strong>Pendaftaran</strong></nav>
                <div class="topbar-actions">
                    <span class="topbar-date">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</span>
                    <span class="divider" aria-hidden="true"></span>
                    <button class="user-menu" type="button" aria-label="Akun Nadia Putri"><span class="initials">NP</span><span><span class="user-name">Nadia Putri</span><span class="user-id">Pasien &bull; PS-00128</span></span><svg class="user-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg></button>
                </div>
            </header>

            <main class="content">
                <section class="welcome-row" aria-label="Pendaftaran pemeriksaan">
                    <div class="welcome-heading"><h1>Pendaftaran pemeriksaan</h1><p>Lengkapi informasi kunjungan Anda dan kelola janji pemeriksaan dengan mudah.</p></div>
                </section>
                <section class="success" aria-label="Status pendaftaran">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16 9"/></svg>
                    <div class="success-copy"><strong>Pendaftaran berhasil. Janji Anda sudah terkonfirmasi.</strong><span>Bukti pendaftaran dikirim ke nadia.putri@email.com. Anda dapat memperbarui keluhan di bawah ini.</span></div>
                    <span class="booking-code">C-261009-012</span>
                </section>

                <div class="columns">
                    <section class="card" aria-labelledby="details-title">
                        <h2 class="card-title" id="details-title">Detail pendaftaran</h2>
                        <p class="card-description">Informasi pasien dan kunjungan yang telah Anda pilih.</p>
                        <div class="section-label"><span>Data pasien</span><span class="badge">Pasien terdaftar</span></div>
                        <div class="patient-grid">
                            <div class="info"><label>Nama pasien</label><div class="value">Nadia Putri</div></div>
                            <div class="info"><label>Nomor rekam medis</label><div class="value">PS-00128</div></div>
                            <div class="info"><label>Nomor ponsel</label><div class="value">0812 3456 7890</div></div>
                            <div class="info"><label>Tanggal lahir &bull; usia</label><div class="value">12 Mei 1998 &bull; 28 tahun</div></div>
                        </div>
                        <hr class="separator">
                        <div class="section-label">Jadwal &amp; informasi pemeriksaan</div>
                        <div class="doctor">
                            <img src="{{ asset('img/Doctor_portrait.png') }}" alt="Foto dr. Andi">
                            <span><span class="doctor-name">dr. Andi</span><span class="doctor-role">Dokter Umum</span></span>
                            <span class="badge">Dokter Anda</span>
                        </div>
                        <div class="visit-grid">
                            <div class="info"><label>Tanggal pemeriksaan</label><div class="field"><span>Jumat, 9 Oktober 2026</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16"/></svg></div></div>
                            <div class="info"><label>Waktu pemeriksaan</label><div class="field"><span>09.00–09.30 WIB</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div></div>
                            <div class="info"><label>Jenis layanan</label><div class="value">Pemeriksaan umum</div></div>
                            <div class="info"><label>Metode pembayaran</label><div class="value">Umum / pribadi</div></div>
                            <div class="info full-width"><label for="complaint">Keluhan / tujuan kunjungan *</label><textarea class="field" id="complaint" name="complaint">Kontrol kesehatan setelah pemeriksaan 24 September. Kondisi sudah membaik, ingin berkonsultasi kembali.</textarea><p class="hint">Sampaikan keluhan agar dokter dapat mempersiapkan pemeriksaan.</p></div>
                        </div>
                        <div class="form-footer"><p class="form-note">Perubahan keluhan tidak mengubah jadwal Anda.</p><button class="primary-button" type="button"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>Simpan perubahan</button></div>
                    </section>

                    <aside class="side-stack">
                        <section class="card side-card" aria-labelledby="summary-title">
                            <h2 class="card-title" id="summary-title">Ringkasan janji Anda</h2>
                            <span class="badge success-badge">Terkonfirmasi</span>
                            <div class="summary-list">
                                <div class="summary-row"><span class="summary-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 5H5a2 2 0 0 0-2 2v2a7 7 0 0 0 7 7h1a7 7 0 0 0 7-7V7a2 2 0 0 0-2-2h-3v5h5"/><path d="M11 16v1a4 4 0 0 0 4 4h2"/><circle cx="19" cy="21" r="1"/></svg></span><span><span class="summary-label">Dokter</span><span class="summary-value">dr. Andi &bull; Dokter Umum</span></span></div>
                                <div class="summary-row"><span class="summary-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16"/></svg></span><span><span class="summary-label">Tanggal &amp; waktu</span><span class="summary-value">9 Oktober 2026 &bull; 09.00 WIB</span></span></div>
                                <div class="summary-row"><span class="summary-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg></span><span><span class="summary-label">Lokasi pemeriksaan</span><span class="summary-value">ClinicOne &bull; Ruang 01</span></span></div>
                            </div>
                            <div class="queue"><span class="queue-label">NOMOR ANTREAN</span><span class="queue-number">A-012</span><span class="queue-code">Kode: C-261009-012</span></div>
                            <div class="price"><span>Biaya konsultasi</span><strong>Rp100.000</strong></div>
                            <p class="payment-note">Dibayar di klinik. Belum termasuk obat atau tindakan tambahan bila diperlukan.</p>
                            <button class="download" type="button"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12m-5-5 5 5 5-5"/><path d="M5 17v3h14v-3"/></svg>Unduh bukti pendaftaran</button>
                        </section>
                        <section class="card side-card" aria-labelledby="arrival-title">
                            <h2 class="arrival-title" id="arrival-title">Sebelum datang</h2>
                            <p class="arrival-copy">Hadir 15 menit lebih awal. Bawa identitas diri dan tunjukkan bukti pendaftaran kepada petugas.</p>
                            <div class="arrival-actions"><a href="#ubah-jadwal">Ubah jadwal</a><a href="#batalkan-janji">Batalkan janji</a></div>
                        </section>
                    </aside>
                </div>
            </main>

        </div>
    </div>
    <script>
        (() => {
            const app = document.querySelector('.app');
            const menuToggle = document.querySelector('.mobile-menu-toggle');
            const sidebarBackdrop = document.querySelector('.sidebar-backdrop');
            const firstSidebarLink = app.querySelector('.sidebar .nav-link');
            const mobileViewport = window.matchMedia('(max-width: 680px)');

            function setSidebarOpen(isOpen, restoreFocus = false) {
                const isMobileViewport = mobileViewport.matches;

                app.classList.toggle('sidebar-open', isMobileViewport && isOpen);
                app.classList.toggle('sidebar-collapsed', !isMobileViewport && !isOpen);
                document.body.classList.toggle('sidebar-open', isMobileViewport && isOpen);
                menuToggle.setAttribute('aria-expanded', String(isOpen));
                menuToggle.setAttribute('aria-label', isOpen ? 'Tutup menu pasien' : 'Buka menu pasien');

                if (isOpen && isMobileViewport) {
                    firstSidebarLink.focus();
                } else if (restoreFocus) {
                    menuToggle.focus();
                }
            }

            function isSidebarOpen() {
                return mobileViewport.matches
                    ? app.classList.contains('sidebar-open')
                    : !app.classList.contains('sidebar-collapsed');
            }

            setSidebarOpen(!mobileViewport.matches);
            menuToggle.addEventListener('click', () => {
                setSidebarOpen(!isSidebarOpen());
            });
            sidebarBackdrop.addEventListener('click', () => setSidebarOpen(false, true));
            app.querySelectorAll('.sidebar a').forEach((link) => {
                link.addEventListener('click', () => {
                    if (mobileViewport.matches) {
                        setSidebarOpen(false);
                    }
                });
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && isSidebarOpen()) {
                    setSidebarOpen(false, true);
                }
            });
            mobileViewport.addEventListener('change', (event) => {
                setSidebarOpen(!event.matches);
            });
        })();
    </script>
</body>
</html>