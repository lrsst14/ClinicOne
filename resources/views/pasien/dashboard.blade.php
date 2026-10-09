<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f4f8fd">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Beranda Pasien | ClinicOne</title>
    <style>
        :root {
            color-scheme: light;
            font-family: "Instrument Sans", Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #29405f;
            background: #f4f8fd;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        * { box-sizing: border-box; }
        body { min-width: 320px; min-height: 100vh; margin: 0; }
        a { color: inherit; text-decoration: none; }
        button { font: inherit; color: inherit; }

        .dashboard { display: grid; min-height: 100vh; grid-template-columns: 220px minmax(0, 1fr); }
        .sidebar { position: sticky; top: 0; display: flex; height: 100vh; flex-direction: column; padding: 20px 10px 12px; border-right: 1px solid #e6edf6; background: #fff; }
        .brand { display: inline-flex; align-items: center; gap: 8px; padding: 0 6px; color: #263b59; }
        .brand-mark { display: grid; width: 25px; height: 25px; flex: 0 0 auto; place-items: center; border-radius: 6px; color: #fff; background: #347cf0; }
        .brand-mark svg { width: 17px; height: 17px; }
        .brand-name { display: block; font-size: 18.8px; font-weight: 700; letter-spacing: -.04em; line-height: 1.1; }
        .brand-caption { display: block; margin-top: 3px; color: #8092ad; font-size: 11px; line-height: 1; }
        .nav-section-label { margin: 28px 0 8px; color: #96a4b8; font-size: 11px; font-weight: 600; letter-spacing: .045em; text-transform: uppercase; }
        .nav-list { display: grid; gap: 5px; }
        .nav-link { display: flex; min-height: 34px; align-items: center; gap: 9px; padding: 0 9px; border-radius: 6px; color: #697e9b; font-size: 11.3px; transition: color 150ms ease, background 150ms ease; }
        .nav-link:hover, .nav-link.is-active { color: #347cf0; background: #eaf2ff; }
        .nav-link.is-active { font-weight: 600; }
        .nav-link svg { width: 14px; height: 14px; flex: 0 0 auto; }
        .sidebar-bottom { display: grid; gap: 12px; margin-top: auto; }
        .clinic-status { padding: 10px 9px; border-radius: 7px; background: #f3f7fd; }
        .clinic-status-title { display: flex; align-items: center; gap: 5px; color: #425a79; font-size: 11px; font-weight: 600; }
        .clinic-status-title svg { width: 11px; height: 11px; color: #347cf0; }
        .clinic-status p { margin: 5px 0 0; color: #8293ad; font-size: 11px; }
        .logout-link { display: flex; align-items: center; gap: 7px; padding: 0 9px; color: #8293ad; font-size: 11.3px; }
        .logout-link svg { width: 13px; height: 13px; }

        .main-column { display: flex; min-width: 0; min-height: 100vh; flex-direction: column; }
        .topbar { display: flex; min-height: 56px; align-items: center; justify-content: flex-start; gap: 12px; padding: 0 20px 0 26px; border-bottom: 1px solid #e6edf6; background: #fff; }
        .breadcrumbs { display: flex; align-items: center; gap: 10px; color: #8293ad; font-size: 11.3px; white-space: nowrap; }
        .breadcrumbs svg { width: 11px; height: 11px; }
        .breadcrumbs strong { color: #29405f; font-weight: 500; }
        .topbar-actions { display: flex; align-items: center; gap: 13px; margin-left: auto; }
        .topbar-date { color: #8293ad; font-size: 11px; white-space: nowrap; }
        .topbar-divider { width: 1px; height: 25px; background: #e6edf6; }
        .user-menu { display: flex; align-items: center; gap: 8px; border: 0; background: transparent; text-align: left; cursor: pointer; }
        .user-initials { display: grid; width: 27px; height: 27px; place-items: center; border-radius: 50%; color: #347cf0; background: #eaf2ff; font-size: 11.3px; font-weight: 600; }
        .user-name { display: block; color: #29405f; font-size: 11px; font-weight: 600; }
        .user-id { display: block; margin-top: 2px; color: #8293ad; font-size: 11px; }

        .page-content { width: min(100%, 1300px); flex: 1; margin: 0 auto; padding: 25px 20px 12px 26px; }
        .welcome-row { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 17px; }
        .welcome-heading h1 { margin: 0; color: #29405f; font-size: clamp(25px, 2vw, 31.3px); font-weight: 700; letter-spacing: -.04em; line-height: 1.2; }
        .welcome-heading p { margin: 5px 0 0; color: #8293ad; font-size: 12.5px; }
        .primary-button { display: inline-flex; min-height: 35px; flex: 0 0 auto; align-items: center; justify-content: center; gap: 7px; padding: 0 14px; border: 1px solid #347cf0; border-radius: 6px; color: #fff; background: #347cf0; box-shadow: 0 2px 5px #347cf022; font-size: 11.3px; font-weight: 600; transition: background 150ms ease; }
        .primary-button:hover { background: #286de0; text-decoration: none; }
        .primary-button svg { width: 13px; height: 13px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin-bottom: 17px; }
        .stat-card, .card { border: 1px solid #e6edf6; border-radius: 9px; background: #fff; box-shadow: 0 3px 10px #29405f05; }
        .stat-card { min-height: 91px; padding: 14px; }
        .stat-heading { display: flex; align-items: center; justify-content: space-between; gap: 6px; color: #8293ad; font-size: 11.3px; }
        .stat-heading svg { width: 14px; height: 14px; flex: 0 0 auto; color: #347cf0; }
        .stat-value { margin-top: 7px; color: #29405f; font-size: 26.3px; font-weight: 700; letter-spacing: -.04em; line-height: 1; }
        .stat-caption { margin-top: 6px; color: #8293ad; font-size: 11px; }
        .dashboard-grid { display: grid; grid-template-columns: minmax(0, 1.85fr) minmax(220px, .9fr); align-items: start; gap: 17px; }
        .main-stack, .side-stack { display: grid; min-width: 0; gap: 17px; }
        .card { padding: 16px; }
        .card-heading { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .card-heading h2, .doctor-card h2, .quick-card h2 { margin: 0; color: #29405f; font-size: 16.3px; font-weight: 650; letter-spacing: -.02em; }
        .card-subtitle { margin: 5px 0 0; color: #8293ad; font-size: 11.3px; line-height: 1.5; }
        .appointment-doctor { display: flex; align-items: center; gap: 10px; margin-top: 13px; }
        .doctor-avatar { display: block; width: 39px; height: 39px; flex: 0 0 auto; overflow: hidden; border: 1px solid #edf1f6; border-radius: 7px; background: #edf5ff; object-fit: cover; object-position: center 25%; }
        .doctor-avatar--large { width: 57px; height: 57px; border-radius: 8px; }
        .doctor-name { display: block; color: #29405f; font-size: 12.5px; font-weight: 650; }
        .doctor-role { display: block; margin-top: 4px; color: #8293ad; font-size: 11px; }
        .status-badge { margin-left: auto; padding: 5px 9px; border-radius: 999px; color: #1e9a7a; background: #eaf8f4; font-size: 11px; font-weight: 600; white-space: nowrap; }
        .appointment-details { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 13px 14px; margin-top: 13px; padding-top: 13px; border-top: 1px solid #edf1f6; }
        .detail-item { display: flex; min-width: 0; align-items: center; gap: 9px; }
        .detail-icon { display: grid; width: 29px; height: 29px; flex: 0 0 auto; place-items: center; border-radius: 7px; color: #347cf0; background: #eaf2ff; }
        .detail-icon svg { width: 14px; height: 14px; }
        .detail-label { display: block; color: #8293ad; font-size: 11px; }
        .detail-value { display: block; margin-top: 4px; overflow: hidden; color: #29405f; font-size: 11.3px; text-overflow: ellipsis; white-space: nowrap; }
        .appointment-footer { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 14px; }
        .appointment-note { margin: 0; color: #8293ad; font-size: 11px; }
        .outline-button { display: inline-flex; min-height: 30px; align-items: center; justify-content: center; gap: 6px; padding: 0 10px; border: 1px solid #e2eaf4; border-radius: 6px; color: #347cf0; background: #fff; font-size: 11px; font-weight: 600; white-space: nowrap; transition: background 150ms ease; }
        .outline-button:hover { background: #f7faff; text-decoration: none; }
        .outline-button svg { width: 13px; height: 13px; }
        .doctor-card h2, .quick-card h2 { margin-bottom: 14px; }
        .doctor-profile { display: flex; align-items: center; gap: 10px; }
        .doctor-profile .doctor-name { font-size: 17.5px; }
        .doctor-profile .doctor-role { font-size: 11.3px; }
        .doctor-location { display: block; margin-top: 5px; color: #347cf0; font-size: 11px; }
        .doctor-description { margin: 13px 0 12px; color: #8293ad; font-size: 11.3px; line-height: 1.55; }
        .doctor-hours { display: flex; align-items: center; gap: 6px; margin: 0 0 12px; color: #425a79; font-size: 11px; }
        .doctor-hours svg { width: 13px; height: 13px; color: #347cf0; }
        .doctor-card .outline-button { width: 100%; min-height: 31px; }
        .history-card { padding-bottom: 11px; }
        .text-link { display: inline-flex; align-items: center; gap: 4px; color: #347cf0; font-size: 11px; font-weight: 500; }
        .text-link svg { width: 11px; height: 11px; }
        .history-list { display: grid; gap: 1px; margin-top: 9px; }
        .history-row { display: grid; grid-template-columns: 29px minmax(0, 1fr) auto auto; align-items: center; gap: 10px; padding: 6px 0; }
        .history-date { color: #8293ad; font-size: 11px; white-space: nowrap; }
        .status-badge--small { margin-left: 0; padding: 4px 8px; font-size: 11px; }
        .quick-list { display: grid; gap: 11px; }
        .quick-link { display: flex; align-items: center; gap: 8px; color: #425a79; font-size: 11px; transition: color 150ms ease; }
        .quick-link:hover { color: #347cf0; }
        .quick-link > svg:first-child { width: 13px; height: 13px; color: #347cf0; }
        .quick-link > svg:last-child { width: 12px; height: 12px; margin-left: auto; color: #8293ad; }
        .page-footer { display: flex; min-height: 30px; align-items: center; justify-content: space-between; gap: 15px; color: #8293ad; font-size: 11px; }
        .page-footer-links { display: flex; gap: 9px; }
        .page-footer-links a:hover { color: #347cf0; }

        .mobile-menu-toggle { display: grid; width: 34px; height: 34px; flex: 0 0 auto; place-items: center; border: 1px solid #e6edf6; border-radius: 7px; color: #425a79; background: #fff; cursor: pointer; }
        .mobile-menu-toggle:hover { border-color: #b9d2ff; color: #347cf0; background: #f8faff; }
        .mobile-menu-toggle svg { width: 18px; height: 18px; }
        .sidebar-backdrop { display: none; }
        body.sidebar-open { overflow: hidden; }

        @media (min-width: 681px) {
            .dashboard.sidebar-collapsed { grid-template-columns: minmax(0, 1fr); }
            .dashboard.sidebar-collapsed > .sidebar { display: none; }
        }

        @media (min-width: 1500px) {
            .dashboard { grid-template-columns: 230px minmax(0, 1fr); }
            .sidebar { padding-right: 14px; padding-left: 14px; }
            .topbar { min-height: 64px; padding-right: 30px; padding-left: 36px; }
            .page-content { padding: 34px 30px 16px 36px; }
            .stat-card { min-height: 105px; padding: 18px; }
            .card { padding: 20px; }
        }

        @media (max-width: 900px) {
            .dashboard { grid-template-columns: 150px minmax(0, 1fr); }
            .topbar { padding-right: 14px; padding-left: 18px; }
            .page-content { padding-right: 14px; padding-left: 18px; }
            .stats-grid { gap: 9px; }
            .stat-card { padding: 11px; }
            .dashboard-grid { grid-template-columns: minmax(0, 1.5fr) minmax(190px, .85fr); gap: 12px; }
            .main-stack, .side-stack { gap: 12px; }
            .card { padding: 13px; }
        }

        @media (max-width: 680px) {
            .dashboard { grid-template-columns: minmax(0, 1fr); }
            .sidebar { position: fixed; z-index: 30; inset: 0 auto 0 0; width: min(82vw, 280px); max-width: calc(100vw - 48px); min-width: 0; height: 100vh; height: 100dvh; padding: 20px 12px 14px; overflow-y: auto; border-right: 1px solid #e6edf6; border-bottom: 0; box-shadow: 10px 0 30px #29405f14; transform: translateX(-100%); visibility: hidden; transition: transform 180ms ease, visibility 180ms ease; }
            .dashboard.sidebar-open .sidebar { transform: translateX(0); visibility: visible; }
            .sidebar-backdrop { position: fixed; z-index: 29; inset: 0; display: none; width: 100%; border: 0; padding: 0; background: #1d2d45a3; }
            .dashboard.sidebar-open .sidebar-backdrop { display: block; }
            .nav-list { display: grid; width: 100%; min-width: 0; gap: 5px; margin-top: 0; overflow: visible; }
            .nav-link { min-height: 38px; padding: 0 9px; font-size: 12.5px; }
            .sidebar-bottom { margin-top: auto; }
            .topbar { min-height: 48px; justify-content: flex-start; gap: 9px; padding: 0 14px; }
            .breadcrumbs { min-width: 0; overflow: hidden; text-overflow: ellipsis; }
            .topbar-date, .user-id, .topbar-divider { display: none; }
            .topbar-actions { flex: 0 0 auto; gap: 8px; margin-left: auto; }
            .page-content { padding: 19px 14px 10px; }
            .welcome-row { align-items: flex-start; }
            .welcome-heading p { max-width: 260px; line-height: 1.5; }
            .primary-button { min-height: 33px; padding: 0 9px; font-size: 11px; }
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 9px; }
            .stat-card { min-height: 82px; }
            .dashboard-grid { grid-template-columns: 1fr; gap: 12px; }
            .side-stack { grid-template-columns: repeat(2, minmax(0, 1fr)); align-items: start; }
        }

        @media (max-width: 430px) {
            .welcome-row { flex-direction: column; align-items: stretch; gap: 12px; }
            .primary-button { align-self: flex-start; padding: 0 12px; font-size: 11.3px; }
            .appointment-details { grid-template-columns: 1fr; gap: 11px; }
            .side-stack { grid-template-columns: 1fr; }
            .card { padding: 14px; }
            .history-row { grid-template-columns: 29px minmax(0, 1fr) auto; gap: 7px; }
            .history-row .history-date { display: none; }
            .page-footer { padding: 7px 0; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/clinicone-interface-scale.css') }}">
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar" id="patient-sidebar">
            <a class="brand" href="{{ url('/pasien/dashboard') }}" aria-label="ClinicOne, beranda pasien">
                <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M9 4h6v5h5v6h-5v5H9v-5H4V9h5V4Z" fill="currentColor"/></svg></span>
                <span><span class="brand-name">ClinicOne</span><span class="brand-caption">Klinik Umum</span></span>
            </a>
            <p class="nav-section-label">Menu pasien</p>
            <nav class="nav-list" aria-label="Menu pasien">
                <a class="nav-link is-active" href="{{ url('/pasien/dashboard') }}" aria-current="page"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><rect x="14" y="14" width="6" height="6" rx="1"/></svg>Beranda</a>
                <a class="nav-link" href="{{ route('pasien.pendaftaran') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="6" width="16" height="14" rx="2"/><path d="M8 3v6m8-6v6M4 11h16M12 14v5m-2.5-2.5h5"/></svg>Pendaftaran</a>
                <a class="nav-link" href="{{ route('pasien.jadwal') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16M8 14h.01M12 14h.01M16 14h.01M8 17h.01M12 17h.01"/></svg>Cek jadwal dokter</a>
                <a class="nav-link" href="{{ route('pasien.riwayat') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5h6v3H9zM9 12h6m-6 4h6"/></svg>Riwayat Pemeriksaan</a>
                <a class="nav-link" href="{{ route('pasien.profil-dokter') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 4H5a2 2 0 0 0-2 2v2a7 7 0 0 0 7 7h1a7 7 0 0 0 7-7V6a2 2 0 0 0-2-2h-2v5h4"/><path d="M11 15v1a4 4 0 0 0 4 4h2"/><circle cx="19" cy="20" r="2"/></svg>Profil Dokter</a>
            </nav>
            <div class="sidebar-bottom">
                <div class="clinic-status">
                    <div class="clinic-status-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 20h18M5 20V6h9v14m0-9h5v9M8 9h2m-2 4h2m-2 4h2m7-1h.01"/></svg>Klinik siap melayani</div>
                    <p>Jam praktik: 08.00 - 12.00</p>
                </div>
                <a class="logout-link" href="{{ url('/pasien/login') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 17l5-5-5-5m5 5H3"/><path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/></svg>Logout</a>
            </div>
        </aside>
        <div class="sidebar-backdrop" aria-hidden="true"></div>

        <div class="main-column">
            <header class="topbar">
                <button class="mobile-menu-toggle" type="button" aria-label="Buka menu pasien" aria-controls="patient-sidebar" aria-expanded="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <nav class="breadcrumbs" aria-label="Breadcrumb"><span>Halaman pasien</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg><strong>Beranda</strong></nav>
                <div class="topbar-actions">
                    <span class="topbar-date">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</span>
                    <span class="topbar-divider" aria-hidden="true"></span>
                    <button class="user-menu" type="button" aria-label="Akun Nadia Putri"><span class="user-initials" aria-hidden="true">NP</span><span><span class="user-name">Nadia Putri</span><span class="user-id">Pasien &bull; PS-00128</span></span><svg class="user-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg></button>
                </div>
            </header>

            <main class="page-content">
                <section class="welcome-row" aria-label="Ringkasan beranda">
                    <div class="welcome-heading"><h1>Selamat pagi, Nadia!</h1><p>Semoga hari Anda menyenangkan. Mari jaga kesehatan bersama ClinicOne.</p></div>
                    <a class="primary-button" href="{{ route('pasien.pendaftaran') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14m-7-7h14"/></svg>Daftar pemeriksaan</a>
                </section>

                <section class="stats-grid" aria-label="Ringkasan pemeriksaan">
                    <article class="stat-card"><div class="stat-heading">Janji mendatang<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16m-8 3v5m-2.5-2.5h5"/></svg></div><div class="stat-value">1</div><div class="stat-caption">Jumat, 9 Oktober 2026</div></article>
                    <article class="stat-card"><div class="stat-heading">Total pemeriksaan<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5h6v3H9zM9 14l2 2 4-4"/></svg></div><div class="stat-value">3</div><div class="stat-caption">Seluruh kunjungan selesai</div></article>
                    <article class="stat-card"><div class="stat-heading">Pemeriksaan terakhir<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5m4-1v5l3 2"/></svg></div><div class="stat-value">24 Sep</div><div class="stat-caption">2026 &bull; Pemeriksaan umum</div></article>
                    <article class="stat-card"><div class="stat-heading">Status akun<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 3 8 3v5c0 5-3.4 8.1-8 10-4.6-1.9-8-5-8-10V6l8-3Z"/><path d="m9 12 2 2 4-4"/></svg></div><div class="stat-value">Aktif</div><div class="stat-caption">Data pasien sudah lengkap</div></article>
                </section>

                <div class="dashboard-grid">
                    <div class="main-stack">
                        <section class="card appointment-card" aria-labelledby="appointment-heading">
                            <div class="card-heading"><h2 id="appointment-heading">Janji pemeriksaan mendatang</h2></div>
                            <p class="card-subtitle">Pemeriksaan Anda sudah terkonfirmasi. Sampai bertemu di klinik!</p>
                            <div class="appointment-doctor">
                                <img class="doctor-avatar" src="{{ asset('img/Doctor_portrait.png') }}" alt="dr. Andi">
                                <div><span class="doctor-name">dr. Andi</span><span class="doctor-role">Dokter Umum</span></div>
                                <span class="status-badge">Terkonfirmasi</span>
                            </div>
                            <div class="appointment-details">
                                <div class="detail-item"><span class="detail-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16m-8 3v5m-2.5-2.5h5"/></svg></span><span><span class="detail-label">Tanggal pemeriksaan</span><span class="detail-value">Jumat, 9 Oktober 2026</span></span></div>
                                <div class="detail-item"><span class="detail-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><span><span class="detail-label">Waktu pemeriksaan</span><span class="detail-value">09.00–09.30 WIB</span></span></div>
                                <div class="detail-item"><span class="detail-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg></span><span><span class="detail-label">Lokasi</span><span class="detail-value">ClinicOne &bull; Ruang 01</span></span></div>
                                <div class="detail-item"><span class="detail-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16v11H4z"/><path d="M8 7V5h8v2m-8 4h.01M8 15h.01m4-4h.01m-.01 4h.01m4-4h.01m-.01 4h.01"/></svg></span><span><span class="detail-label">Nomor antrean</span><span class="detail-value">A-012 &bull; C-261009-012</span></span></div>
                            </div>
                            <div class="appointment-footer"><p class="appointment-note">Mohon hadir 15 menit sebelum pemeriksaan.</p><a class="outline-button" href="#detail-janji"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>Lihat detail janji</a></div>
                        </section>

                        <section class="card history-card" id="riwayat" aria-labelledby="history-heading">
                            <div class="card-heading"><h2 id="history-heading">Pemeriksaan terakhir</h2><a class="text-link" href="#riwayat-lengkap">Lihat semua<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a></div>
                            <div class="history-list">
                                <div class="history-row"><span class="detail-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5h6v3H9zM9 12h6m-6 4h4"/></svg></span><span><span class="detail-value">Pemeriksaan umum</span><span class="detail-label">ISPA ringan &bull; dr. Andi</span></span><span class="history-date">24 Sep 2026</span><span class="status-badge status-badge--small">Selesai</span></div>
                                <div class="history-row"><span class="detail-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5h6v3H9zM9 12h6m-6 4h4"/></svg></span><span><span class="detail-value">Kontrol kesehatan</span><span class="detail-label">Kondisi umum baik &bull; dr. Andi</span></span><span class="history-date">10 Agu 2026</span><span class="status-badge status-badge--small">Selesai</span></div>
                            </div>
                        </section>
                    </div>

                    <div class="side-stack">
                        <section class="card doctor-card" id="profil-dokter" aria-labelledby="doctor-heading">
                            <h2 id="doctor-heading">Dokter Anda</h2>
                            <div class="doctor-profile">
                                <img class="doctor-avatar doctor-avatar--large" src="{{ asset('img/Doctor_portrait.png') }}" alt="dr. Andi">
                                <div><span class="doctor-name">dr. Andi</span><span class="doctor-role">Dokter Umum</span><span class="doctor-location">ClinicOne &bull; Bandung</span></div>
                            </div>
                            <p class="doctor-description">Perawatan kesehatan umum untuk Anda dan keluarga, dengan pendekatan yang ramah dan menyeluruh.</p>
                            <p class="doctor-hours"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>Hari ini &bull; 08.00–12.00 WIB</p>
                            <a class="outline-button" href="{{ route('pasien.profil-dokter') }}">Lihat profil dokter</a>
                        </section>
                        <section class="card quick-card" aria-labelledby="quick-heading">
                            <h2 id="quick-heading">Akses cepat</h2>
                            <nav class="quick-list" aria-label="Akses cepat">
                                <a class="quick-link" href="{{ route('pasien.jadwal') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16m-8 3v5m-2.5-2.5h5"/></svg>Cek jadwal dokter<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></a>
                                <a class="quick-link" href="{{ route('pasien.riwayat') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5h6v3H9zM9 12h6m-6 4h4"/></svg>Riwayat pemeriksaan<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></a>
                                <a class="quick-link" href="{{ route('pasien.pendaftaran') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16m-8 3v5m-2.5-2.5h5"/></svg>Daftar pemeriksaan<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></a>
                            </nav>
                        </section>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        (() => {
            const app = document.querySelector('.dashboard');
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