<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Beranda | ClinicOne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">
    <div class="flex min-h-screen">
        <aside id="doctor-sidebar" data-doctor-sidebar class="fixed inset-y-0 left-0 z-40 flex w-56 -translate-x-full flex-col justify-between border-r border-slate-200 bg-white px-4 py-6 transition-transform duration-300 ease-in-out md:translate-x-0">
            <div>
                <div class="mb-8 flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 3h6v6h6v6h-6v6H9v-6H3V9h6z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900 leading-none">ClinicOne</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">Klinik Umum</p>
                    </div>
                </div>

                <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-400 mb-3">Menu utama</p>
                <nav class="space-y-1">
                    <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-3 rounded-lg border-r-2 border-blue-600 bg-blue-50 px-3 py-2.5 text-sm font-semibold text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5M5 9v11h14V9M9 20v-6h6v6" />
                        </svg>
                        Beranda
                    </a>
                    <a href="{{ route('dokter.janji') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Kelola Janji
                    </a>
                    <a href="{{ route('dokter.jadwal') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3m8-3v3M4 7h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1zm4 7 1.5 1.5L13 11" />
                        </svg>
                        Pengaturan
                    </a>
                    <a href="{{ route('dokter.profil') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Profil Dokter
                    </a>
                </nav>
            </div>

            <div>
                <div class="mb-4 rounded-lg bg-slate-50 border border-slate-200 px-3 py-2.5">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0"></span>
                        <p class="text-xs font-semibold text-slate-700">Klinik siap melayani</p>
                    </div>
                    <p class="text-[11px] text-slate-400 pl-4">Jam praktik 08.00 – 12.00</p>
                </div>
                <form method="POST" action="{{ route('dokter.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <button type="button" data-doctor-sidebar-overlay aria-label="Tutup menu" class="fixed inset-0 z-30 hidden bg-slate-900/40 md:hidden"></button>

        <main data-doctor-main class="ml-0 flex min-h-screen flex-1 flex-col md:ml-56">
            <header class="flex flex-col justify-between gap-4 border-b border-slate-200 bg-white px-4 py-4 sm:flex-row sm:items-center sm:px-8">
                <div class="flex min-w-0 items-start gap-3">
                    <button type="button" data-doctor-sidebar-toggle aria-controls="doctor-sidebar" aria-expanded="false" aria-label="Buka menu" class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Beranda</p>
                        <h1 class="text-2xl font-bold text-slate-900 mt-0.5">Selamat pagi, dr. Andi</h1>
                        <p class="text-sm text-slate-400 mt-0.5">Berikut ringkasan aktivitas klinik hari ini.</p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 sm:gap-4">
                    <p class="whitespace-nowrap text-[10px] text-slate-500 sm:hidden">{{ now()->format('d/m/Y') }}</p>
                    <p class="hidden whitespace-nowrap text-xs text-slate-500 sm:block">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</p>
                    <div class="flex items-center gap-3 rounded-full border border-slate-200 bg-white px-2 py-1.5 shadow-sm">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#dfeefd] text-xs font-bold text-[#2d6ae5]">A</div>
                        <div class="mr-1 leading-tight">
                            <p class="text-sm font-semibold text-slate-800">dr. Andi</p>
                            <p class="text-[11px] text-slate-400">Dokter Umum</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </header>

            <div class="flex-1 px-8 py-7 space-y-7">
                <div class="grid grid-cols-4 gap-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Janji Hari Ini</p>
                            <p class="mt-2 text-4xl font-bold text-slate-900">8</p>
                            <p class="mt-1 text-xs text-slate-400">Total janji terjadwal</p>
                        </div>
                        <div class="rounded-lg bg-blue-50 p-2 text-blue-500 shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Menunggu Konfirmasi</p>
                            <p class="mt-2 text-4xl font-bold text-slate-900">3</p>
                            <p class="mt-1 text-xs text-slate-400">Perlu ditinjau</p>
                        </div>
                        <div class="rounded-lg bg-amber-50 p-2 text-amber-500 shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Janji Selesai</p>
                            <p class="mt-2 text-4xl font-bold text-slate-900">5</p>
                            <p class="mt-1 text-xs text-slate-400">Konsultasi selesai</p>
                        </div>
                        <div class="rounded-lg bg-sky-50 p-2 text-sky-500 shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Slot Tersedia</p>
                            <p class="mt-2 text-4xl font-bold text-slate-900">4</p>
                            <p class="mt-1 text-xs text-slate-400">Masih bisa dipesan</p>
                        </div>
                        <div class="rounded-lg bg-emerald-50 p-2 text-emerald-500 shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                            </svg>
                        </div>
                    </div>
                </div>

                <section
                    class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
                    data-registration-chart
                    data-endpoint="{{ route('dashboard.registration-chart') }}"
                    aria-labelledby="registration-chart-title"
                >
                    <div class="mb-4 flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <h2 id="registration-chart-title" class="text-base font-bold text-slate-900">Pendaftaran akun</h2>
                            <p class="mt-1 text-xs text-slate-400">Jumlah akun baru per hari selama 7 hari terakhir.</p>
                        </div>
                        <div class="text-right">
                            <p id="registration-total" class="text-2xl font-bold tabular-nums text-blue-600" aria-live="polite">—</p>
                            <p class="mt-1 text-[11px] text-slate-400">Total 7 hari</p>
                        </div>
                    </div>
                    <p id="registration-chart-status" class="mb-2 min-h-[18px] text-xs text-slate-400" role="status" aria-live="polite">
                        Memuat data pendaftaran...
                    </p>
                    <svg
                        class="h-auto w-full overflow-visible"
                        viewBox="0 0 700 260"
                        role="img"
                        aria-label="Grafik jumlah pendaftaran akun selama tujuh hari terakhir"
                        data-chart-svg
                    ></svg>
                </section>

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Jadwal Hari Ini</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Kelola kunjungan dan ketersediaan waktu praktik.</p>
                        </div>
                        <div class="flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-sm text-slate-600 cursor-pointer hover:bg-slate-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium">Kamis, 9 Oktober 2026</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Time</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Patient</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800">08.00</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-sky-100 flex items-center justify-center text-xs font-bold text-sky-700 shrink-0">BS</div>
                                        <span class="font-medium text-slate-800">Budi Santoso</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Dikonfirmasi
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="rounded-lg border border-slate-200 px-4 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Detail</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800">08.30</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-violet-100 flex items-center justify-center text-xs font-bold text-violet-700 shrink-0">SA</div>
                                        <span class="font-medium text-slate-800">Sinta Amelia</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 border border-amber-200 px-3 py-1 text-xs font-semibold text-amber-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="rounded-lg border border-slate-200 px-4 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Detail</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800">09.00</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center text-xs font-bold text-emerald-700 shrink-0">RP</div>
                                        <span class="font-medium text-slate-800">Rina Pratiwi</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 border border-sky-200 px-3 py-1 text-xs font-semibold text-sky-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                                        Selesai
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="rounded-lg border border-slate-200 px-4 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Detail</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
