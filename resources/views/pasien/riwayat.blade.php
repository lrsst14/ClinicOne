<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f4f8fd">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Riwayat Pemeriksaan | ClinicOne</title>
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
        button, input, select { font: inherit; }

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
        .logout-form { margin: 0; }
        .logout-link { display: flex; align-items: center; gap: 7px; padding: 0 9px; border: 0; color: #8293ad; background: transparent; font: inherit; font-size: 11.3px; text-align: left; cursor: pointer; }
        .logout-link svg { width: 13px; height: 13px; }

        .main-column { display: flex; min-width: 0; min-height: 100vh; flex-direction: column; }
        .topbar { display: flex; min-height: 56px; align-items: center; justify-content: flex-start; gap: 12px; padding: 0 20px 0 26px; border-bottom: 1px solid #e6edf6; background: #fff; }
        .breadcrumbs { display: flex; align-items: center; gap: 10px; color: #8293ad; font-size: 11.3px; white-space: nowrap; }
        .breadcrumbs svg { width: 11px; height: 11px; }
        .breadcrumbs strong { color: #29405f; font-weight: 500; }
        .topbar-actions { display: flex; align-items: center; gap: 13px; margin-left: auto; }
        .topbar-date { color: #8293ad; font-size: 11px; white-space: nowrap; }
        .topbar-divider { width: 1px; height: 25px; background: #e6edf6; }
        .user-menu { display: flex; align-items: center; gap: 8px; border: 0; background: transparent; text-align: left; }
        .user-initials { display: grid; width: 27px; height: 27px; place-items: center; border-radius: 50%; color: #347cf0; background: #eaf2ff; font-size: 11.3px; font-weight: 600; }
        .user-name { display: block; color: #29405f; font-size: 11px; font-weight: 600; }
        .user-id { display: block; margin-top: 2px; color: #8293ad; font-size: 11px; }

        .page-content { width: min(100%, 1300px); flex: 1; margin: 0 auto; padding: 25px 20px 12px 26px; }
        .page-heading { display: flex; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 16px; }
        .page-heading h1 { margin: 0; color: #29405f; font-size: clamp(25px, 2vw, 31.3px); font-weight: 700; letter-spacing: -.04em; line-height: 1.2; }
        .page-heading p { margin: 5px 0 0; color: #8293ad; font-size: 12.5px; }
        .outline-button { display: inline-flex; min-height: 31px; flex: 0 0 auto; align-items: center; justify-content: center; gap: 6px; padding: 0 10px; border: 1px solid #e6edf6; border-radius: 6px; color: #347cf0; background: #fff; font-size: 11px; font-weight: 600; cursor: pointer; transition: border-color 150ms ease, background 150ms ease; }
        .outline-button:hover { border-color: #b9d2ff; background: #f8faff; }
        .outline-button svg { width: 13px; height: 13px; }
        .card { min-width: 0; border: 1px solid #e6edf6; border-radius: 9px; background: #fff; box-shadow: 0 3px 10px #29405f05; }
        .filter-card { display: grid; grid-template-columns: minmax(0, 1fr) 105px 150px; align-items: end; gap: 12px; margin-bottom: 16px; padding: 12px; }
        .filter-field { display: grid; min-width: 0; gap: 5px; }
        .filter-field label { color: #425a79; font-size: 11px; font-weight: 550; }
        .input-wrap { position: relative; }
        .filter-control { width: 100%; height: 31px; padding: 0 9px; border: 1px solid #e8eef6; border-radius: 6px; outline: none; color: #425a79; background: #f9fbfe; font-size: 11px; }
        .filter-control:focus { border-color: #9bbfff; box-shadow: 0 0 0 2px #347cf018; }
        .search-input { padding-right: 30px; }
        .search-icon { position: absolute; top: 50%; right: 9px; width: 13px; height: 13px; color: #617894; pointer-events: none; transform: translateY(-50%); }
        .history-layout { display: grid; grid-template-columns: minmax(205px, .75fr) minmax(0, 1.7fr); align-items: start; gap: 15px; }
        .history-sidebar { display: grid; gap: 10px; }
        .list-heading { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 1px 0 2px; }
        .list-heading h2 { margin: 0; color: #425a79; font-size: 12.5px; font-weight: 650; }
        .record-count { color: #8293ad; font-size: 11px; }
        .record-list { display: grid; gap: 10px; }
        .record-card { display: block; width: 100%; padding: 12px; border: 1px solid #e6edf6; border-radius: 8px; color: inherit; background: #fff; text-align: left; cursor: pointer; transition: border-color 150ms ease, background 150ms ease, box-shadow 150ms ease; }
        .record-card:hover { border-color: #b9d2ff; }
        .record-card.is-selected { border-color: #5790ff; background: #eaf2ff; box-shadow: 0 0 0 1px #5790ff22; }
        .record-topline { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .record-date { color: #617894; font-size: 11px; }
        .status-badge { flex: 0 0 auto; padding: 4px 7px; border-radius: 999px; color: #1e9a7a; background: #eaf8f4; font-size: 11px; font-weight: 600; }
        .record-title { display: block; margin-top: 9px; color: #29405f; font-size: 11.3px; font-weight: 650; }
        .record-description { display: block; margin-top: 4px; color: #8293ad; font-size: 11px; line-height: 1.4; }
        .record-code { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-top: 8px; color: #8293ad; font-size: 11px; }
        .record-code svg { width: 12px; height: 12px; color: #347cf0; }
        .patient-card { padding: 14px; }
        .patient-card h2 { margin: 0 0 11px; color: #29405f; font-size: 13.8px; font-weight: 650; }
        .patient-details { display: grid; gap: 10px; }
        .patient-detail span { display: block; color: #8293ad; font-size: 11px; }
        .patient-detail strong { display: block; margin-top: 4px; color: #425a79; font-size: 11px; font-weight: 550; }
        .exam-card { padding: 15px; }
        .exam-heading { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; padding-bottom: 10px; }
        .exam-heading h2 { margin: 0; color: #29405f; font-size: 16.3px; font-weight: 650; }
        .exam-meta { margin: 4px 0 0; color: #8293ad; font-size: 11px; }
        .doctor-note { display: flex; align-items: center; gap: 7px; margin-bottom: 11px; padding: 8px; border-radius: 6px; color: #425a79; background: #f8fafd; font-size: 11px; }
        .doctor-note svg { width: 13px; height: 13px; flex: 0 0 auto; color: #347cf0; }
        .vitals-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 8px; margin-bottom: 12px; }
        .vital-card { min-width: 0; padding: 8px; border-radius: 6px; background: #f3f7fc; }
        .vital-label { display: block; color: #8293ad; font-size: 11px; }
        .vital-value { display: block; margin-top: 5px; color: #29405f; font-size: 17.5px; font-weight: 650; line-height: 1; white-space: nowrap; }
        .vital-unit { display: block; margin-top: 4px; color: #8293ad; font-size: 11px; }
        .exam-section { padding: 0 0 10px; }
        .exam-section h3 { margin: 0 0 4px; color: #425a79; font-size: 11px; font-weight: 650; }
        .exam-section p { margin: 0; color: #8293ad; font-size: 11px; line-height: 1.5; }
        .prescriptions { display: grid; gap: 8px; padding: 10px 0; border-top: 1px solid #edf1f6; }
        .prescription-heading { margin: 0; color: #425a79; font-size: 11px; font-weight: 650; }
        .prescription { display: grid; grid-template-columns: 22px minmax(90px, 1fr) minmax(0, 1.5fr); align-items: center; gap: 7px; color: #425a79; font-size: 11px; }
        .prescription-icon { display: grid; width: 21px; height: 21px; place-items: center; border-radius: 5px; color: #347cf0; background: #eaf2ff; }
        .prescription-icon svg { width: 12px; height: 12px; }
        .prescription strong { font-weight: 550; }
        .prescription span:last-child { color: #8293ad; font-size: 11px; line-height: 1.4; }
        .advice { margin-top: 4px; padding: 9px; border-radius: 6px; color: #347cf0; background: #eaf2ff; }
        .advice strong { display: block; font-size: 11px; font-weight: 650; }
        .advice p { margin: 4px 0 0; color: #617894; font-size: 11px; line-height: 1.5; }
        .exam-footer { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding-top: 10px; color: #8293ad; font-size: 11px; }
        .empty-state { display: none; padding: 18px 12px; border: 1px dashed #dce5f1; border-radius: 8px; color: #8293ad; background: #fff; font-size: 11px; line-height: 1.5; text-align: center; }
        .empty-state.is-visible { display: block; }
        .footer { display: flex; min-height: 30px; align-items: center; justify-content: space-between; gap: 15px; color: #8293ad; font-size: 11px; }
        .footer-links { display: flex; gap: 9px; }
        .footer-links a:hover { color: #347cf0; }

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
            .filter-card, .patient-card, .exam-card { padding: 18px; }
        }
        @media (max-width: 900px) {
            .dashboard { grid-template-columns: 150px minmax(0, 1fr); }
            .topbar { padding-right: 14px; padding-left: 18px; }
            .page-content { padding-right: 14px; padding-left: 18px; }
            .history-layout { grid-template-columns: minmax(180px, .8fr) minmax(0, 1.5fr); gap: 11px; }
            .vitals-grid { gap: 6px; }
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
            .filter-card { grid-template-columns: minmax(0, 1fr) 100px; gap: 9px; }
            .filter-field:first-child { grid-column: 1 / -1; }
            .history-layout { grid-template-columns: 1fr; }
            .record-list { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .patient-details { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 430px) {
            .page-heading { align-items: flex-start; flex-direction: column; }
            .outline-button { align-self: flex-start; }
            .record-list { grid-template-columns: 1fr; }
            .vitals-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .prescription { grid-template-columns: 22px minmax(0, 1fr); }
            .prescription span:last-child { grid-column: 2; }
            .exam-footer { align-items: flex-start; flex-direction: column; }
            .footer { padding: 7px 0; }
        }
        @media print {
            :root, body { background: #fff; }
            .sidebar, .sidebar-backdrop, .mobile-menu-toggle, .topbar, .page-heading, .filter-card, .history-sidebar, .footer, .exam-footer .outline-button { display: none !important; }
            .dashboard, .main-column { display: block; min-height: 0; }
            .page-content { width: 100%; padding: 0; }
            .history-layout { display: block; }
            .exam-card { border: 0; box-shadow: none; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/clinicone-interface-scale.css') }}">
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar" id="patient-sidebar">
            <a class="brand" href="{{ route('pasien.dashboard') }}" aria-label="ClinicOne, beranda pasien">
                <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M9 4h6v5h5v6h-5v5H9v-5H4V9h5V4Z" fill="currentColor"/></svg></span>
                <span><span class="brand-name">ClinicOne</span><span class="brand-caption">Klinik Umum</span></span>
            </a>
            <p class="nav-section-label">Menu pasien</p>
            <nav class="nav-list" aria-label="Menu pasien">
                <a class="nav-link" href="{{ route('pasien.dashboard') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><rect x="14" y="14" width="6" height="6" rx="1"/></svg>Beranda</a>
                <a class="nav-link" href="{{ route('pasien.pendaftaran') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="6" width="16" height="14" rx="2"/><path d="M8 3v6m8-6v6M4 11h16M12 14v5m-2.5-2.5h5"/></svg>Pendaftaran</a>
                <a class="nav-link" href="{{ route('pasien.jadwal') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16M8 14h.01M12 14h.01M16 14h.01M8 17h.01M12 17h.01"/></svg>Cek jadwal dokter</a>
                <a class="nav-link is-active" href="{{ route('pasien.riwayat') }}" aria-current="page"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5h6v3H9zM9 12h6m-6 4h6"/></svg>Riwayat Pemeriksaan</a>
                <a class="nav-link" href="{{ route('pasien.profil-dokter') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 4H5a2 2 0 0 0-2 2v2a7 7 0 0 0 7 7h1a7 7 0 0 0 7-7V6a2 2 0 0 0-2-2h-2v5h4"/><path d="M11 15v1a4 4 0 0 0 4 4h2"/><circle cx="19" cy="20" r="2"/></svg>Profil Dokter</a>
            </nav>
            <div class="sidebar-bottom">
                <div class="clinic-status">
                    <div class="clinic-status-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 20h18M5 20V6h9v14m0-9h5v9M8 9h2m-2 4h2m-2 4h2m7-1h.01"/></svg>Klinik siap melayani</div>
                    <p>Jam praktik: 08.00 - 12.00</p>
                </div>
                <form class="logout-form" action="{{ route('pasien.logout') }}" method="POST">
                    @csrf
                    <button class="logout-link" type="submit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 17l5-5-5-5m5 5H3"/><path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/></svg>Logout</button>
                </form>
            </div>
        </aside>
        <div class="sidebar-backdrop" aria-hidden="true"></div>

        <div class="main-column">
            <header class="topbar">
                <button class="mobile-menu-toggle" type="button" aria-label="Buka menu pasien" aria-controls="patient-sidebar" aria-expanded="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <nav class="breadcrumbs" aria-label="Breadcrumb"><span>Halaman pasien</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg><strong>Riwayat Pemeriksaan</strong></nav>
                <div class="topbar-actions">
                    <span class="topbar-date">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</span>
                    <span class="topbar-divider" aria-hidden="true"></span>
                    <button class="user-menu" type="button" aria-label="Akun {{ auth()->user()->name }}"><span class="user-initials" aria-hidden="true">{{ mb_substr(auth()->user()->name, 0, 1) }}</span><span><span class="user-name">{{ auth()->user()->name }}</span><span class="user-id">Pasien &bull; ID {{ auth()->id() }}</span></span></button>
                </div>
            </header>

            <main class="page-content">
                <header class="page-heading">
                    <div><h1>Riwayat pemeriksaan</h1><p>Catatan kunjungan, hasil pemeriksaan, dan resep Anda tersimpan dengan aman.</p></div>
                    <button class="outline-button" type="button" data-print><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12m-5-5 5 5 5-5"/><path d="M5 17v3h14v-3"/></svg>Unduh riwayat</button>
                </header>

                <form class="card filter-card" id="history-filters" role="search">
                    <div class="filter-field">
                        <label for="history-search">Cari riwayat</label>
                        <span class="input-wrap"><input class="filter-control search-input" id="history-search" type="search" placeholder="Cari keluhan, diagnosis, atau nomor pemeriksaan"><svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg></span>
                    </div>
                    <div class="filter-field">
                        <label for="history-year">Tahun</label>
                        <select class="filter-control" id="history-year"><option value="all">Semua tahun</option><option value="2026" selected>2026</option></select>
                    </div>
                    <div class="filter-field">
                        <label for="history-status">Status pemeriksaan</label>
                        <select class="filter-control" id="history-status"><option value="all">Semua status</option><option value="Selesai">Selesai</option></select>
                    </div>
                </form>

                <div class="history-layout">
                    <aside class="history-sidebar">
                        <div class="list-heading"><h2>Daftar kunjungan</h2><span class="record-count" id="record-count">3 pemeriksaan</span></div>
                        <div class="record-list" id="record-list">
                            <button class="record-card is-selected" type="button" data-record="rm-260924-003" data-year="2026" data-status="Selesai" aria-pressed="true">
                                <span class="record-topline"><span class="record-date">24 September 2026</span><span class="status-badge">Selesai</span></span>
                                <span class="record-title">Pemeriksaan umum</span>
                                <span class="record-description">ISPA ringan &bull; dr. Andi</span>
                                <span class="record-code"><span>RM-260924-003</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></span>
                            </button>
                            <button class="record-card" type="button" data-record="rm-260810-002" data-year="2026" data-status="Selesai" aria-pressed="false">
                                <span class="record-topline"><span class="record-date">10 Agustus 2026</span><span class="status-badge">Selesai</span></span>
                                <span class="record-title">Kontrol kesehatan</span>
                                <span class="record-description">Kondisi umum baik &bull; dr. Andi</span>
                                <span class="record-code"><span>RM-260810-002</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></span>
                            </button>
                            <button class="record-card" type="button" data-record="rm-260618-001" data-year="2026" data-status="Selesai" aria-pressed="false">
                                <span class="record-topline"><span class="record-date">18 Juni 2026</span><span class="status-badge">Selesai</span></span>
                                <span class="record-title">Pemeriksaan umum</span>
                                <span class="record-description">Gastritis ringan &bull; dr. Andi</span>
                                <span class="record-code"><span>RM-260618-001</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></span>
                            </button>
                        </div>
                        <p class="empty-state" id="empty-state">Tidak ada riwayat yang sesuai dengan pencarian atau filter Anda.</p>
                        <section class="card patient-card" aria-labelledby="patient-title">
                            <h2 id="patient-title">Identitas pasien</h2>
                            <div class="patient-details">
                                <div class="patient-detail"><span>Nama pasien</span><strong>Nadia Putri</strong></div>
                                <div class="patient-detail"><span>Nomor rekam medis</span><strong>PS-00128 &bull; Perempuan, 28 tahun</strong></div>
                            </div>
                        </section>
                    </aside>

                    <section class="card exam-card" aria-labelledby="exam-title">
                        <div class="exam-heading">
                            <div><h2 id="exam-title">Detail pemeriksaan</h2><p class="exam-meta" id="exam-meta">24 September 2026 &bull; 09.00 WIB &bull; RM-260924-003</p></div>
                            <span class="status-badge" id="exam-status">Selesai</span>
                        </div>
                        <div class="doctor-note"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 4H5a2 2 0 0 0-2 2v2a7 7 0 0 0 7 7h1a7 7 0 0 0 7-7V6a2 2 0 0 0-2-2h-2v5h4"/><path d="M11 15v1a4 4 0 0 0 4 4h2"/><circle cx="19" cy="20" r="2"/></svg><span id="doctor-summary">Ditangani oleh dr. Andi &bull; Dokter Umum</span></div>
                        <div class="vitals-grid">
                            <div class="vital-card"><span class="vital-label">Tekanan darah</span><strong class="vital-value" id="vital-pressure">118/78</strong><span class="vital-unit">mmHg</span></div>
                            <div class="vital-card"><span class="vital-label">Denyut nadi</span><strong class="vital-value" id="vital-pulse">78</strong><span class="vital-unit">kali/menit</span></div>
                            <div class="vital-card"><span class="vital-label">Suhu tubuh</span><strong class="vital-value" id="vital-temperature">37,4</strong><span class="vital-unit">&deg;C</span></div>
                            <div class="vital-card"><span class="vital-label">Berat badan</span><strong class="vital-value" id="vital-weight">54</strong><span class="vital-unit">kg</span></div>
                        </div>
                        <section class="exam-section"><h3>Keluhan utama</h3><p id="exam-complaint">Batuk, pilek, dan demam ringan selama 3 hari. Tidak ada sesak napas. Nafsu makan sedikit menurun.</p></section>
                        <section class="exam-section"><h3>Diagnosis</h3><p id="exam-diagnosis">Infeksi saluran pernapasan atas (ISPA) ringan.</p></section>
                        <section class="prescriptions" aria-labelledby="prescription-title">
                            <h3 class="prescription-heading" id="prescription-title">Resep obat</h3>
                            <div class="prescription"><span class="prescription-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m9 15 6-6"/><path d="M7.5 17.5a4 4 0 0 1 0-5.7l4.3-4.3a4 4 0 0 1 5.7 5.7l-4.3 4.3a4 4 0 0 1-5.7 0Z"/></svg></span><strong id="medicine-one">Paracetamol 500 mg</strong><span id="dose-one">3&times; sehari bila demam, sesudah makan &bull; 3 hari</span></div>
                            <div class="prescription"><span class="prescription-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m9 15 6-6"/><path d="M7.5 17.5a4 4 0 0 1 0-5.7l4.3-4.3a4 4 0 0 1 5.7 5.7l-4.3 4.3a4 4 0 0 1-5.7 0Z"/></svg></span><strong id="medicine-two">Cetirizine 10 mg</strong><span id="dose-two">1&times; sehari pada malam hari &bull; 5 hari</span></div>
                        </section>
                        <div class="advice"><strong>Anjuran dokter</strong><p id="exam-advice">Istirahat cukup dan perbanyak minum air. Kembali ke klinik jika demam berlanjut atau muncul sesak napas. Janji kontrol: 9 Oktober 2026, 09.00 WIB.</p></div>
                        <div class="exam-footer"><span>Catatan ini merupakan ringkasan pemeriksaan Anda.</span><button class="outline-button" type="button" data-print><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12m-5-5 5 5 5-5"/><path d="M5 17v3h14v-3"/></svg>Unduh hasil</button></div>
                    </section>
                </div>
            </main>

        </div>
    </div>
    <script>
        (() => {
            const filterForm = document.getElementById('history-filters');
            const searchInput = document.getElementById('history-search');
            const yearFilter = document.getElementById('history-year');
            const statusFilter = document.getElementById('history-status');
            const recordCards = Array.from(document.querySelectorAll('.record-card'));
            const count = document.getElementById('record-count');
            const emptyState = document.getElementById('empty-state');
            const detailFields = {
                meta: document.getElementById('exam-meta'),
                status: document.getElementById('exam-status'),
                pressure: document.getElementById('vital-pressure'),
                pulse: document.getElementById('vital-pulse'),
                temperature: document.getElementById('vital-temperature'),
                weight: document.getElementById('vital-weight'),
                complaint: document.getElementById('exam-complaint'),
                diagnosis: document.getElementById('exam-diagnosis'),
                medicineOne: document.getElementById('medicine-one'),
                doseOne: document.getElementById('dose-one'),
                medicineTwo: document.getElementById('medicine-two'),
                doseTwo: document.getElementById('dose-two'),
                advice: document.getElementById('exam-advice'),
            };
            const records = {
                'rm-260924-003': {
                    meta: '24 September 2026 • 09.00 WIB • RM-260924-003',
                    pressure: '118/78', pulse: '78', temperature: '37,4', weight: '54',
                    complaint: 'Batuk, pilek, dan demam ringan selama 3 hari. Tidak ada sesak napas. Nafsu makan sedikit menurun.',
                    diagnosis: 'Infeksi saluran pernapasan atas (ISPA) ringan.',
                    medicineOne: 'Paracetamol 500 mg', doseOne: '3× sehari bila demam, sesudah makan • 3 hari',
                    medicineTwo: 'Cetirizine 10 mg', doseTwo: '1× sehari pada malam hari • 5 hari',
                    advice: 'Istirahat cukup dan perbanyak minum air. Kembali ke klinik jika demam berlanjut atau muncul sesak napas. Janji kontrol: 9 Oktober 2026, 09.00 WIB.',
                },
                'rm-260810-002': {
                    meta: '10 Agustus 2026 • 10.30 WIB • RM-260810-002',
                    pressure: '116/76', pulse: '74', temperature: '36,8', weight: '54',
                    complaint: 'Kontrol rutin. Kondisi badan terasa lebih segar dan tidak ada keluhan baru.',
                    diagnosis: 'Kondisi umum baik. Tanda vital dalam batas normal.',
                    medicineOne: 'Vitamin B kompleks', doseOne: '1× sehari sesudah makan • 7 hari',
                    medicineTwo: '—', doseTwo: 'Tidak ada resep tambahan.',
                    advice: 'Pertahankan pola makan seimbang, istirahat cukup, dan lanjutkan aktivitas secara bertahap.',
                },
                'rm-260618-001': {
                    meta: '18 Juni 2026 • 08.30 WIB • RM-260618-001',
                    pressure: '120/80', pulse: '80', temperature: '36,9', weight: '55',
                    complaint: 'Nyeri ulu hati setelah terlambat makan, disertai mual ringan.',
                    diagnosis: 'Gastritis ringan.',
                    medicineOne: 'Antasida DOEN', doseOne: '3× sehari sebelum makan • 5 hari',
                    medicineTwo: 'Omeprazole 20 mg', doseTwo: '1× sehari sebelum sarapan • 7 hari',
                    advice: 'Makan teratur dalam porsi kecil dan hindari makanan pedas serta minuman berkafein untuk sementara.',
                },
            };

            function updateDetails(recordCard) {
                const record = records[recordCard.dataset.record];
                detailFields.meta.textContent = record.meta;
                detailFields.status.textContent = recordCard.dataset.status;
                Object.entries(record).forEach(([key, value]) => {
                    if (detailFields[key]) {
                        detailFields[key].textContent = value;
                    }
                });
            }

            function updateList() {
                const query = searchInput.value.trim().toLocaleLowerCase('id');
                const selectedYear = yearFilter.value;
                const selectedStatus = statusFilter.value;
                const visibleRecords = recordCards.filter((recordCard) => {
                    const matchesSearch = recordCard.textContent.toLocaleLowerCase('id').includes(query);
                    const matchesYear = selectedYear === 'all' || recordCard.dataset.year === selectedYear;
                    const matchesStatus = selectedStatus === 'all' || recordCard.dataset.status === selectedStatus;
                    const isVisible = matchesSearch && matchesYear && matchesStatus;
                    recordCard.hidden = !isVisible;

                    return isVisible;
                });
                count.textContent = `${visibleRecords.length} pemeriksaan`;
                emptyState.classList.toggle('is-visible', visibleRecords.length === 0);

                if (!visibleRecords.some((recordCard) => recordCard.classList.contains('is-selected')) && visibleRecords.length > 0) {
                    selectRecord(visibleRecords[0]);
                }
            }

            function selectRecord(recordCard) {
                recordCards.forEach((candidate) => {
                    const isSelected = candidate === recordCard;
                    candidate.classList.toggle('is-selected', isSelected);
                    candidate.setAttribute('aria-pressed', String(isSelected));
                });
                updateDetails(recordCard);
            }

            recordCards.forEach((recordCard) => {
                recordCard.addEventListener('click', () => selectRecord(recordCard));
            });
            filterForm.addEventListener('submit', (event) => event.preventDefault());
            filterForm.addEventListener('input', updateList);
            filterForm.addEventListener('change', updateList);
            document.querySelectorAll('[data-print]').forEach((button) => {
                button.addEventListener('click', () => window.print());
            });
        })();
    </script>
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
