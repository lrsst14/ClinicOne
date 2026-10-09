<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f4f8fd">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Cek Jadwal Dokter | ClinicOne</title>
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

        .app { display: grid; min-height: 100vh; grid-template-columns: 220px minmax(0, 1fr); }
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
        .page-heading { margin-bottom: 16px; }
        .page-heading h1 { margin: 0; color: #29405f; font-size: clamp(25px, 2vw, 31.3px); font-weight: 700; letter-spacing: -.04em; line-height: 1.2; }
        .page-heading p { margin: 5px 0 0; color: #8293ad; font-size: 12.5px; }
        .card { min-width: 0; border: 1px solid #e6edf6; border-radius: 9px; background: #fff; box-shadow: 0 3px 10px #29405f05; }
        .doctor-strip { display: flex; min-height: 60px; align-items: center; gap: 11px; margin-bottom: 16px; padding: 9px 13px; }
        .doctor-photo { width: 38px; height: 38px; flex: 0 0 auto; overflow: hidden; border: 1px solid #edf1f6; border-radius: 6px; background: #edf5ff; object-fit: cover; object-position: center 25%; }
        .doctor-info { min-width: 85px; }
        .doctor-name { display: block; color: #29405f; font-size: 11.3px; font-weight: 650; }
        .doctor-role { display: block; margin-top: 4px; color: #8293ad; font-size: 11px; }
        .strip-divider { width: 1px; height: 30px; margin: 0 5px; background: #edf1f6; }
        .hours-icon, .summary-icon { display: grid; width: 26px; height: 26px; flex: 0 0 auto; place-items: center; border-radius: 6px; color: #347cf0; background: #eaf2ff; }
        .hours-icon svg, .summary-icon svg { width: 14px; height: 14px; }
        .hours-copy span { display: block; color: #8293ad; font-size: 11px; }
        .hours-copy strong { display: block; margin-top: 4px; color: #425a79; font-size: 11px; font-weight: 550; }
        .open-badge { margin-left: auto; padding: 5px 8px; border-radius: 999px; color: #1e9a7a; background: #eaf8f4; font-size: 11px; font-weight: 600; white-space: nowrap; }
        .schedule-layout { display: grid; grid-template-columns: minmax(0, 1.9fr) minmax(210px, .92fr); align-items: start; gap: 16px; }
        .calendar-card { padding: 16px; }
        .calendar-heading { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding-bottom: 12px; border-bottom: 1px solid #edf1f6; }
        .calendar-heading h2, .summary-card h2, .next-card h2 { margin: 0; color: #29405f; font-size: 15px; font-weight: 650; letter-spacing: -.02em; }
        .calendar-heading p { margin: 5px 0 0; color: #8293ad; font-size: 11px; }
        .calendar-controls { display: flex; align-items: center; gap: 5px; }
        .today-button, .week-button { display: grid; min-width: 27px; height: 27px; place-items: center; border: 1px solid #e6edf6; border-radius: 6px; color: #8293ad; background: #fff; cursor: pointer; }
        .today-button { padding: 0 9px; color: #347cf0; font-size: 11px; font-weight: 600; }
        .week-button svg { width: 13px; height: 13px; }
        .today-button:hover, .week-button:hover { border-color: #b9d2ff; background: #f6f9ff; }
        .table-wrap { overflow-x: auto; scrollbar-width: thin; }
        .schedule-table { width: 100%; min-width: 490px; margin-top: 8px; border-collapse: separate; border-spacing: 4px 5px; table-layout: fixed; text-align: center; }
        .schedule-table th { height: 40px; padding: 3px 2px; color: #8293ad; font-size: 11px; font-weight: 500; }
        .schedule-table th:first-child { width: 32px; text-align: left; }
        .day-name, .day-number { display: block; }
        .day-number { margin-top: 2px; color: #29405f; font-size: 16.3px; font-weight: 650; line-height: 1; }
        .day-today { border-radius: 6px; color: #347cf0 !important; background: #eaf2ff; }
        .day-today .day-number { color: #347cf0; }
        .today-caption { display: block; margin-top: 3px; font-size: 11px; }
        .schedule-table tbody th { height: 23px; color: #8293ad; font-size: 11px; font-weight: 500; text-align: left; white-space: nowrap; }
        .schedule-table td { height: 24px; padding: 0; }
        .slot { display: grid; min-height: 24px; place-items: center; border-radius: 5px; color: #347cf0; background: #eaf2ff; font-size: 11px; white-space: nowrap; }
        .slot.is-full { color: #8293ad; background: #f3f7fc; }
        .slot.is-empty { color: #aab8ca; background: #f8fafd; }
        .slot.is-booked { color: #fff; background: #347cf0; font-size: 11px; font-weight: 600; }
        .legend { display: flex; flex-wrap: wrap; gap: 13px; margin-top: 11px; padding-top: 10px; border-top: 1px solid #edf1f6; color: #8293ad; font-size: 11px; }
        .legend-item { display: inline-flex; align-items: center; gap: 5px; }
        .legend-swatch { width: 8px; height: 8px; border-radius: 2px; background: #eaf2ff; }
        .legend-swatch.is-full { background: #f3f7fc; }
        .legend-swatch.is-booked { background: #347cf0; }
        .schedule-note { margin: 11px 0 0; color: #8293ad; font-size: 11px; line-height: 1.5; }
        .side-stack { display: grid; gap: 13px; }
        .summary-card, .next-card { padding: 15px; }
        .summary-date { margin: 6px 0 9px; color: #8293ad; font-size: 11px; }
        .appointment-badge { display: inline-flex; padding: 4px 8px; border-radius: 999px; color: #1e9a7a; background: #eaf8f4; font-size: 11px; font-weight: 600; }
        .summary-list { display: grid; gap: 10px; margin: 12px 0; }
        .summary-row { display: flex; min-width: 0; align-items: center; gap: 8px; }
        .summary-copy { min-width: 0; }
        .summary-label { display: block; color: #8293ad; font-size: 11px; }
        .summary-value { display: block; margin-top: 3px; overflow-wrap: anywhere; color: #425a79; font-size: 11px; font-weight: 550; line-height: 1.35; }
        .booking-link { display: flex; min-height: 31px; align-items: center; justify-content: center; gap: 6px; margin-top: 11px; border-radius: 6px; color: #fff; background: #347cf0; font-size: 11px; font-weight: 600; transition: background 150ms ease; }
        .booking-link:hover { background: #286de0; }
        .next-date { margin: 7px 0 0; color: #8293ad; font-size: 11px; }
        .next-time { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin: 10px 0; }
        .next-time strong { color: #347cf0; font-size: 16.3px; font-weight: 650; }
        .next-time .appointment-badge { color: #347cf0; background: #eaf2ff; }
        .next-copy { margin: 0; color: #8293ad; font-size: 11px; line-height: 1.5; }
        .footer { display: flex; min-height: 30px; align-items: center; justify-content: space-between; gap: 15px; color: #8293ad; font-size: 11px; }
        .footer-links { display: flex; gap: 9px; }
        .footer-links a:hover { color: #347cf0; }

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
            .page-content { padding: 34px 30px 16px 36px; }
            .calendar-card, .summary-card, .next-card { padding: 20px; }
        }
        @media (max-width: 900px) {
            .app { grid-template-columns: 150px minmax(0, 1fr); }
            .topbar { padding-right: 14px; padding-left: 18px; }
            .page-content { padding-right: 14px; padding-left: 18px; }
            .schedule-layout { grid-template-columns: minmax(0, 1fr) 210px; gap: 11px; }
            .calendar-card { padding: 13px; }
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
            .topbar-date, .user-id, .topbar-divider { display: none; }
            .topbar-actions { flex: 0 0 auto; gap: 8px; margin-left: auto; }
            .page-content { padding: 19px 14px 10px; }
            .schedule-layout { grid-template-columns: 1fr; }
            .side-stack { grid-template-columns: repeat(2, minmax(0, 1fr)); align-items: start; }
        }
        @media (max-width: 430px) {
            .doctor-strip { display: grid; grid-template-columns: auto minmax(0, 1fr); gap: 8px 10px; padding: 9px; }
            .doctor-photo { grid-column: 1; grid-row: 1; }
            .doctor-info { grid-column: 2; grid-row: 1; min-width: 0; }
            .strip-divider { display: none; }
            .hours-icon { grid-column: 1; grid-row: 2; }
            .hours-copy { grid-column: 2; grid-row: 2; min-width: 0; }
            .open-badge { grid-column: 1 / -1; justify-self: start; margin-left: 0; padding: 5px 6px; font-size: 11px; }
            .calendar-heading { align-items: flex-start; flex-direction: column; }
            .calendar-controls { align-self: flex-end; }
            .side-stack { grid-template-columns: 1fr; }
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
            <p class="nav-section-label">Menu pasien</p>
            <nav class="nav-list" aria-label="Menu pasien">
                <a class="nav-link" href="{{ route('pasien.dashboard') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><rect x="14" y="14" width="6" height="6" rx="1"/></svg>Beranda</a>
                <a class="nav-link" href="{{ route('pasien.pendaftaran') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="6" width="16" height="14" rx="2"/><path d="M8 3v6m8-6v6M4 11h16M12 14v5m-2.5-2.5h5"/></svg>Pendaftaran</a>
                <a class="nav-link is-active" href="{{ route('pasien.jadwal') }}" aria-current="page"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16M8 14h.01M12 14h.01M16 14h.01M8 17h.01M12 17h.01"/></svg>Cek Jadwal Dokter</a>
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
                <nav class="breadcrumbs" aria-label="Breadcrumb"><span>Halaman pasien</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg><strong>Cek Jadwal Dokter</strong></nav>
                <div class="topbar-actions">
                    <span class="topbar-date">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</span>
                    <span class="topbar-divider" aria-hidden="true"></span>
                    <button class="user-menu" type="button" aria-label="Akun Nadia Putri"><span class="user-initials" aria-hidden="true">NP</span><span><span class="user-name">Nadia Putri</span><span class="user-id">Pasien &bull; PS-00128</span></span><svg class="user-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg></button>
                </div>
            </header>

            <main class="page-content">
                <header class="page-heading">
                    <h1>Cek jadwal dokter</h1>
                    <p>Lihat jadwal praktik dr. Andi dan ketersediaan waktu pemeriksaan Anda.</p>
                </header>

                <section class="card doctor-strip" aria-label="Informasi praktik dokter">
                    <img class="doctor-photo" src="{{ asset('img/Doctor_portrait.png') }}" alt="Foto dr. Andi">
                    <div class="doctor-info"><span class="doctor-name">dr. Andi</span><span class="doctor-role">Dokter Umum</span></div>
                    <span class="strip-divider" aria-hidden="true"></span>
                    <span class="hours-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
                    <span class="hours-copy"><span>Jam praktik</span><strong>Senin–Sabtu &bull; 08.00–12.00 WIB</strong></span>
                    <span class="open-badge">Klinik sedang buka</span>
                </section>

                <div class="schedule-layout">
                    <section class="card calendar-card" aria-labelledby="calendar-title">
                        <div class="calendar-heading">
                            <div><h2 id="calendar-title">5–10 Oktober 2026</h2><p>Jadwal mingguan &bull; 30 menit per sesi</p></div>
                            <div class="calendar-controls" aria-label="Navigasi kalender">
                                <button class="today-button" id="today-button" type="button">Hari ini</button>
                                <button class="week-button" id="previous-week" type="button" aria-label="Minggu sebelumnya"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg></button>
                                <button class="week-button" id="next-week" type="button" aria-label="Minggu berikutnya"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></button>
                            </div>
                        </div>
                        <div class="table-wrap">
                            <table class="schedule-table" aria-label="Jadwal praktik dr. Andi">
                                <thead><tr id="schedule-days"><th scope="col">WIB</th><th scope="col"><span class="day-name">Sen</span><span class="day-number">5</span></th><th scope="col"><span class="day-name">Sel</span><span class="day-number">6</span></th><th scope="col"><span class="day-name">Rab</span><span class="day-number">7</span></th><th scope="col"><span class="day-name">Kam</span><span class="day-number">8</span></th><th scope="col" class="day-today"><span class="day-name">Jum</span><span class="day-number">9</span><span class="today-caption">Hari ini</span></th><th scope="col"><span class="day-name">Sab</span><span class="day-number">10</span></th></tr></thead>
                                <tbody id="schedule-slots">
                                    <tr><th scope="row">08.00</th><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-full">Penuh</span></td><td><span class="slot is-full">Penuh</span></td><td><span class="slot">Tersedia</span></td></tr>
                                    <tr><th scope="row">08.30</th><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-full">Penuh</span></td><td><span class="slot is-full">Penuh</span></td><td><span class="slot is-full">Penuh</span></td></tr>
                                    <tr><th scope="row">09.00</th><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-full">Penuh</span></td><td><span class="slot is-booked">Janji Anda</span></td><td><span class="slot">Tersedia</span></td></tr>
                                    <tr><th scope="row">09.30</th><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-full">Penuh</span></td><td><span class="slot is-full">Penuh</span></td><td><span class="slot">Tersedia</span></td></tr>
                                    <tr><th scope="row">10.00</th><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot">Tersedia</span></td><td><span class="slot">Tersedia</span></td><td><span class="slot">Tersedia</span></td></tr>
                                    <tr><th scope="row">10.30</th><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot">Tersedia</span></td><td><span class="slot">Tersedia</span></td><td><span class="slot">Tersedia</span></td></tr>
                                    <tr><th scope="row">11.00</th><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot">Tersedia</span></td><td><span class="slot">Tersedia</span></td><td><span class="slot">Tersedia</span></td></tr>
                                    <tr><th scope="row">11.30</th><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot is-empty">—</span></td><td><span class="slot">Tersedia</span></td><td><span class="slot">Tersedia</span></td><td><span class="slot">Tersedia</span></td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="legend" aria-label="Keterangan jadwal">
                            <span class="legend-item"><span class="legend-swatch"></span>Tersedia</span>
                            <span class="legend-item"><span class="legend-swatch is-full"></span>Penuh</span>
                            <span class="legend-item"><span class="legend-swatch is-booked"></span>Janji Anda</span>
                        </div>
                        <p class="schedule-note">Jadwal dapat berubah. Klinik tutup pada hari Minggu dan hari libur nasional.</p>
                    </section>

                    <aside class="side-stack">
                        <section class="card summary-card" aria-labelledby="appointment-title">
                            <h2 id="appointment-title">Jadwal pilihan Anda</h2>
                            <p class="summary-date">Jumat, 9 Oktober 2026</p>
                            <span class="appointment-badge">Janji Anda &bull; Terkonfirmasi</span>
                            <div class="summary-list">
                                <div class="summary-row"><span class="summary-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><span class="summary-copy"><span class="summary-label">Waktu pemeriksaan</span><span class="summary-value">09.00–09.30 WIB</span></span></div>
                                <div class="summary-row"><span class="summary-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4H5a2 2 0 0 0-2 2v2a7 7 0 0 0 7 7h1a7 7 0 0 0 7-7V6a2 2 0 0 0-2-2h-2v5h4"/><path d="M11 15v1a4 4 0 0 0 4 4h2"/></svg></span><span class="summary-copy"><span class="summary-label">Nomor antrean</span><span class="summary-value">A-012 &bull; C-261009-012</span></span></div>
                                <div class="summary-row"><span class="summary-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg></span><span class="summary-copy"><span class="summary-label">Lokasi</span><span class="summary-value">ClinicOne &bull; Ruang 01</span></span></div>
                            </div>
                            <a class="booking-link" href="{{ route('pasien.pendaftaran') }}">Lihat janji saya</a>
                        </section>

                        <section class="card next-card" aria-labelledby="next-appointment-title">
                            <h2 id="next-appointment-title">Waktu tersedia berikutnya</h2>
                            <p class="next-date">Besok, 10 Oktober 2026</p>
                            <div class="next-time"><strong>10.00–10.30 WIB</strong><span class="appointment-badge">Tersedia</span></div>
                            <p class="next-copy">Untuk mengganti waktu kunjungan, gunakan fitur Ubah jadwal pada halaman Pendaftaran.</p>
                            <a class="booking-link" href="{{ route('pasien.pendaftaran') }}">Buka pendaftaran</a>
                        </section>
                    </aside>
                </div>
            </main>
        </div>
    </div>
    <script>
        (() => {
            const calendarStart = new Date(2026, 9, 5);
            const today = new Date(2026, 9, 9);
            const currentStart = new Date(calendarStart);
            const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const times = ['08.00', '08.30', '09.00', '09.30', '10.00', '10.30', '11.00', '11.30'];
            const headings = document.getElementById('schedule-days');
            const slots = document.getElementById('schedule-slots');
            const title = document.getElementById('calendar-title');

            function renderCalendar() {
                const dates = Array.from({ length: 6 }, (_, index) => {
                    const date = new Date(currentStart);
                    date.setDate(date.getDate() + index);

                    return date;
                });
                const first = dates[0];
                const last = dates[5];
                title.textContent = first.getMonth() === last.getMonth()
                    ? `${first.getDate()}–${last.getDate()} ${monthNames[last.getMonth()]} ${last.getFullYear()}`
                    : `${first.getDate()} ${monthNames[first.getMonth()]}–${last.getDate()} ${monthNames[last.getMonth()]} ${last.getFullYear()}`;

                headings.replaceChildren(headings.cells[0]);
                dates.forEach((date) => {
                    const heading = document.createElement('th');
                    const dayName = document.createElement('span');
                    const dayNumber = document.createElement('span');
                    dayName.className = 'day-name';
                    dayName.textContent = dayNames[date.getDay()];
                    dayNumber.className = 'day-number';
                    dayNumber.textContent = date.getDate();
                    heading.scope = 'col';
                    heading.append(dayName, dayNumber);

                    if (date.toDateString() === today.toDateString()) {
                        const caption = document.createElement('span');
                        caption.className = 'today-caption';
                        caption.textContent = 'Hari ini';
                        heading.className = 'day-today';
                        heading.append(caption);
                    }

                    headings.append(heading);
                });

                slots.replaceChildren();
                times.forEach((time, rowIndex) => {
                    const row = document.createElement('tr');
                    const timeHeading = document.createElement('th');
                    timeHeading.scope = 'row';
                    timeHeading.textContent = time;
                    row.append(timeHeading);

                    dates.forEach((date) => {
                        const cell = document.createElement('td');
                        const status = document.createElement('span');
                        const weekday = date.getDay();
                        const isBooking = date.toDateString() === today.toDateString() && rowIndex === 2;
                        let label = 'Tersedia';
                        let statusClass = 'slot';

                        if (weekday <= 3) {
                            label = '—';
                            statusClass += ' is-empty';
                        } else if ((weekday === 4 && rowIndex < 4) || (weekday === 5 && (rowIndex < 2 || rowIndex === 3)) || (weekday === 6 && rowIndex === 1)) {
                            label = 'Penuh';
                            statusClass += ' is-full';
                        } else if (isBooking) {
                            label = 'Janji Anda';
                            statusClass += ' is-booked';
                        }

                        status.className = statusClass;
                        status.textContent = label;
                        cell.append(status);
                        row.append(cell);
                    });

                    slots.append(row);
                });
            }

            document.getElementById('previous-week').addEventListener('click', () => {
                currentStart.setDate(currentStart.getDate() - 7);
                renderCalendar();
            });
            document.getElementById('next-week').addEventListener('click', () => {
                currentStart.setDate(currentStart.getDate() + 7);
                renderCalendar();
            });
            document.getElementById('today-button').addEventListener('click', () => {
                currentStart.setTime(calendarStart.getTime());
                renderCalendar();
            });
        })();
    </script>
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
