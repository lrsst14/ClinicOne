<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f4f8fd">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Profil Dokter | ClinicOne</title>
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
        .profile-layout { display: grid; grid-template-columns: minmax(0, 1.8fr) minmax(220px, .9fr); align-items: start; gap: 16px; }
        .main-stack, .side-stack { display: grid; min-width: 0; gap: 14px; }
        .card { min-width: 0; padding: 15px; border: 1px solid #e6edf6; border-radius: 9px; background: #fff; box-shadow: 0 3px 10px #29405f05; }
        .profile-card { display: grid; grid-template-columns: 163px minmax(0, 1fr); align-items: center; gap: 16px; padding: 12px; }
        .doctor-photo { display: block; width: 100%; height: 174px; border: 1px solid #edf1f6; border-radius: 7px; background: #edf5ff; object-fit: cover; object-position: center 20%; }
        .doctor-content { min-width: 0; }
        .doctor-badge, .open-badge { display: inline-flex; align-items: center; padding: 5px 8px; border-radius: 999px; color: #1e9a7a; background: #eaf8f4; font-size: 11px; font-weight: 600; }
        .doctor-content h2 { margin: 9px 0 2px; color: #29405f; font-size: 23.8px; font-weight: 700; letter-spacing: -.03em; }
        .doctor-specialty { margin: 0; color: #347cf0; font-size: 11.3px; font-weight: 500; }
        .doctor-summary { max-width: 500px; margin: 9px 0 11px; color: #8293ad; font-size: 11px; line-height: 1.6; }
        .profile-facts { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; padding-top: 10px; border-top: 1px solid #edf1f6; }
        .profile-fact span { display: block; color: #8293ad; font-size: 11px; }
        .profile-fact strong { display: block; margin-top: 4px; color: #425a79; font-size: 11px; font-weight: 550; }
        .section-title { margin: 0; color: #29405f; font-size: 13.8px; font-weight: 650; }
        .about-copy { margin: 10px 0; color: #8293ad; font-size: 11px; line-height: 1.6; }
        .divider { height: 1px; margin: 11px 0; border: 0; background: #edf1f6; }
        .service-label { margin: 0 0 9px; color: #425a79; font-size: 11px; font-weight: 600; }
        .service-tags { display: flex; flex-wrap: wrap; gap: 6px; }
        .service-tag { padding: 5px 8px; border-radius: 999px; color: #347cf0; background: #eaf2ff; font-size: 11px; font-weight: 500; }
        .education-list { display: grid; gap: 11px; margin-top: 10px; }
        .education-row { display: flex; align-items: center; gap: 8px; }
        .education-icon { display: grid; width: 25px; height: 25px; flex: 0 0 auto; place-items: center; border-radius: 6px; color: #347cf0; background: #eaf2ff; }
        .education-icon svg { width: 13px; height: 13px; }
        .education-copy strong { display: block; color: #425a79; font-size: 11px; font-weight: 550; }
        .education-copy span { display: block; margin-top: 3px; color: #8293ad; font-size: 11px; }
        .schedule-card h2, .location-card h2 { margin: 0 0 9px; color: #29405f; font-size: 13.8px; font-weight: 650; }
        .open-badge { margin-bottom: 10px; }
        .hours-list { display: grid; gap: 8px; margin: 0; }
        .hours-row { display: flex; justify-content: space-between; gap: 12px; color: #8293ad; font-size: 11px; }
        .hours-row strong { color: #425a79; font-size: 11px; font-weight: 550; text-align: right; }
        .consultation-fee { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin: 11px 0; padding-top: 10px; border-top: 1px solid #edf1f6; color: #8293ad; font-size: 11px; }
        .consultation-fee strong { color: #29405f; font-size: 13.8px; font-weight: 650; }
        .primary-button { display: inline-flex; width: 100%; min-height: 32px; align-items: center; justify-content: center; gap: 6px; border: 1px solid #347cf0; border-radius: 6px; color: #fff; background: #347cf0; font-size: 11px; font-weight: 600; transition: background 150ms ease; }
        .primary-button:hover { background: #286de0; }
        .primary-button svg { width: 13px; height: 13px; }
        .schedule-link { display: block; margin-top: 9px; color: #347cf0; font-size: 11px; text-align: center; }
        .schedule-link:hover, .directions-link:hover { text-decoration: underline; }
        .clinic-photo { display: block; width: 100%; height: 95px; margin-bottom: 9px; border-radius: 6px; background: #edf5ff; object-fit: cover; }
        .clinic-name { display: block; color: #425a79; font-size: 11px; font-weight: 600; }
        .clinic-address { margin: 7px 0; color: #8293ad; font-size: 11px; line-height: 1.5; }
        .clinic-phone { display: flex; align-items: center; gap: 5px; color: #617894; font-size: 11px; }
        .clinic-phone svg { width: 11px; height: 11px; color: #347cf0; }
        .directions-link { display: inline-flex; align-items: center; gap: 4px; margin-top: 8px; color: #347cf0; font-size: 11px; }
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
            .card { padding: 19px; }
            .profile-card { padding: 14px; }
            .doctor-photo { height: 172px; }
        }
        @media (max-width: 900px) {
            .dashboard { grid-template-columns: 150px minmax(0, 1fr); }
            .topbar { padding-right: 14px; padding-left: 18px; }
            .page-content { padding-right: 14px; padding-left: 18px; }
            .profile-layout { grid-template-columns: minmax(0, 1.5fr) minmax(195px, .9fr); gap: 11px; }
            .profile-card { grid-template-columns: 120px minmax(0, 1fr); gap: 12px; }
            .doctor-photo { height: 145px; }
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
            .profile-layout { grid-template-columns: 1fr; }
            .side-stack { grid-template-columns: repeat(2, minmax(0, 1fr)); align-items: start; }
        }
        @media (max-width: 430px) {
            .profile-card { grid-template-columns: 94px minmax(0, 1fr); gap: 10px; }
            .doctor-photo { height: 125px; }
            .doctor-content h2 { font-size: 21.3px; }
            .profile-facts { grid-template-columns: 1fr; gap: 7px; }
            .side-stack { grid-template-columns: 1fr; }
            .footer { padding: 7px 0; }
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
                <a class="nav-link" href="{{ route('pasien.riwayat') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5h6v3H9zM9 12h6m-6 4h6"/></svg>Riwayat Pemeriksaan</a>
                <a class="nav-link is-active" href="{{ route('pasien.profil-dokter') }}" aria-current="page"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 4H5a2 2 0 0 0-2 2v2a7 7 0 0 0 7 7h1a7 7 0 0 0 7-7V6a2 2 0 0 0-2-2h-2v5h4"/><path d="M11 15v1a4 4 0 0 0 4 4h2"/><circle cx="19" cy="20" r="2"/></svg>Profil Dokter</a>
            </nav>
            <div class="sidebar-bottom">
                <div class="clinic-status">
                    <div class="clinic-status-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 20h18M5 20V6h9v14m0-9h5v9M8 9h2m-2 4h2m-2 4h2m7-1h.01"/></svg>Klinik siap melayani</div>
                    <p>Jadwal rutin hari ini: @if ($todaySchedule?->is_open && $todaySchedule->start_time && $todaySchedule->end_time) {{ substr($todaySchedule->start_time, 0, 5) }}–{{ substr($todaySchedule->end_time, 0, 5) }} WIB @else Tutup @endif</p>
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
                <nav class="breadcrumbs" aria-label="Breadcrumb"><span>Halaman pasien</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg><strong>Profil Dokter</strong></nav>
                <div class="topbar-actions">
                    <span class="topbar-date">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</span>
                    <span class="topbar-divider" aria-hidden="true"></span>
                    <button class="user-menu" type="button" aria-label="Akun {{ auth()->user()->name }}"><span class="user-initials" aria-hidden="true">{{ mb_substr(auth()->user()->name, 0, 1) }}</span><span><span class="user-name">{{ auth()->user()->name }}</span><span class="user-id">Pasien &bull; ID {{ auth()->id() }}</span></span></button>
                </div>
            </header>

            <main class="page-content">
                <header class="page-heading">
                    <h1>Kenali dokter Anda</h1>
                    <p>Informasi dokter yang melayani Anda di ClinicOne.</p>
                </header>

                <div class="profile-layout">
                    <div class="main-stack">
                        <section class="card profile-card" aria-labelledby="doctor-name">
                            <img class="doctor-photo" src="{{ $profile?->photo_path ? route('dokter.profil.photo') : asset('img/Doctor_portrait.png') }}" alt="Foto profil dokter">
                            <div class="doctor-content">
                                @if ($profile?->str_number || $profile?->sip_number)
                                    <span class="doctor-badge">Informasi registrasi tersedia</span>
                                @endif
                                <h2 id="doctor-name">{{ trim(($profile?->title ? $profile->title.' ' : '').($profile?->full_name ?? '')) ?: 'Profil dokter belum tersedia' }}</h2>
                                <p class="doctor-specialty">{{ $profile?->specialization ?: 'Informasi spesialisasi belum tersedia.' }}</p>
                                @if ($profile?->bio)
                                    <p class="doctor-summary">{{ $profile->bio }}</p>
                                @endif
                                <div class="profile-facts">
                                    @if ($profile?->str_number)
                                        <div class="profile-fact"><span>Nomor STR</span><strong>{{ $profile->str_number }}</strong></div>
                                    @endif
                                    @if ($profile?->sip_number)
                                        <div class="profile-fact"><span>Nomor SIP</span><strong>{{ $profile->sip_number }}</strong></div>
                                    @endif
                                    @unless ($profile?->str_number || $profile?->sip_number)
                                        <div class="profile-fact"><span>Informasi registrasi</span><strong>Belum tersedia</strong></div>
                                    @endunless
                                </div>
                            </div>
                        </section>

                        <section class="card" aria-labelledby="about-title">
                            <h2 class="section-title" id="about-title">Tentang {{ trim(($profile?->title ? $profile->title.' ' : '').($profile?->full_name ?? 'Dokter')) }}</h2>
                            <p class="about-copy">{{ $profile?->bio ?: 'Informasi tentang dokter belum tersedia.' }}</p>
                            <hr class="divider">
                            <h3 class="service-label">Kontak dokter</h3>
                            <div class="profile-facts">
                                @if ($profile?->phone)
                                    <div class="profile-fact"><span>Telepon</span><strong>{{ $profile->phone }}</strong></div>
                                @endif
                                @if ($profile?->email)
                                    <div class="profile-fact"><span>Email</span><strong>{{ $profile->email }}</strong></div>
                                @endif
                                @unless ($profile?->phone || $profile?->email)
                                    <div class="profile-fact"><span>Kontak</span><strong>Belum tersedia</strong></div>
                                @endunless
                            </div>
                        </section>
                    </div>

                    <aside class="side-stack">
                        <section class="card schedule-card" aria-labelledby="schedule-title">
                            <h2 id="schedule-title">Jadwal praktik</h2>
                            <span class="open-badge">{{ $clinicIsOpen ? 'Klinik sedang buka' : 'Klinik sedang tutup' }}</span>
                            <div class="hours-list">
                                @forelse ($weeklySchedules as $schedule)
                                    @php
                                        $dayNames = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'];
                                    @endphp
                                    <div class="hours-row"><span>{{ $dayNames[$schedule->day_of_week] }}</span><strong>{{ $schedule->is_open && $schedule->start_time && $schedule->end_time ? substr($schedule->start_time, 0, 5).'–'.substr($schedule->end_time, 0, 5).' WIB' : 'Tutup' }}</strong></div>
                                @empty
                                    <div class="hours-row"><span>Jadwal</span><strong>Belum tersedia</strong></div>
                                @endforelse
                            </div>
                            <a class="primary-button" href="{{ route('pasien.pendaftaran') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4m8-4v4M4 10h16m-8 4v5m-2.5-2.5h5"/></svg>Daftar pemeriksaan</a>
                            <a class="schedule-link" href="{{ route('pasien.jadwal') }}">Lihat jadwal lengkap &rarr;</a>
                        </section>
                    </aside>
                </div>
            </main>

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
