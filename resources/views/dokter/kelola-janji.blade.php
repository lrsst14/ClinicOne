<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Kelola Janji | ClinicOne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f4f7] font-sans text-slate-800 antialiased">
    <div class="flex min-h-screen">
        <aside id="doctor-sidebar" data-doctor-sidebar class="fixed inset-y-0 left-0 z-40 flex w-[184px] -translate-x-full flex-col justify-between border-r border-slate-200 bg-white px-3.5 py-6 transition-transform duration-300 ease-in-out md:translate-x-0">
            <div>
                <div class="mb-8 flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#296cff] text-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 3h6v6h6v6h-6v6H9v-6H3V9h6z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[15px] font-bold leading-none text-slate-900">ClinicOne</p>
                        <p class="mt-1 text-[10px] text-slate-400">Klinik Umum</p>
                    </div>
                </div>

                <p class="mb-3 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">Menu utama</p>

                <nav class="space-y-1">
                    <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5M5 9v11h14V9M9 20v-6h6v6" />
                        </svg>
                        Beranda
                    </a>

                    <a href="{{ route('dokter.janji') }}" class="flex items-center gap-3 rounded-xl border-r-2 border-[#4a86ff] bg-[#edf4ff] px-3 py-2.5 text-sm font-semibold text-[#2c6efb] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Kelola Janji
                    </a>

                    <a href="{{ route('dokter.jadwal') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3m8-3v3M4 7h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1zm4 7 1.5 1.5L13 11" />
                        </svg>
                        Pengaturan Jadwal
                    </a>

                    <a href="{{ route('dokter.profil') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 3v5a6 6 0 0012 0V3M4 3h4m8 0h4m-8 11v2a4 4 0 004 4h1a3 3 0 100-6h-1" />
                        </svg>
                        Profil Dokter
                    </a>
                </nav>
            </div>

            <div>
                <div class="mb-4 rounded-xl border border-slate-200 bg-slate-50 px-3 py-3">
                    <div class="mb-1 flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        <p class="text-[11px] font-semibold text-slate-700">Klinik siap melayani</p>
                    </div>
                    <p class="pl-4 text-[10px] text-slate-400">Jam praktik 08.00 – 12.00</p>
                </div>

                <form method="POST" action="{{ route('dokter.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-500 transition-colors hover:bg-slate-50 hover:text-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <button type="button" data-doctor-sidebar-overlay aria-label="Tutup menu" class="fixed inset-0 z-30 hidden bg-slate-900/40 md:hidden"></button>

        <main data-doctor-main class="ml-0 min-w-0 flex-1 md:ml-[184px]">
            <header class="border-b border-slate-200 bg-white px-4 py-5 sm:px-6">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                    <div class="flex min-w-0 items-start gap-3">
                        <button type="button" data-doctor-sidebar-toggle aria-controls="doctor-sidebar" aria-expanded="false" aria-label="Buka menu" class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <p class="text-[13px] font-medium text-slate-400">Manajemen pasien</p>
                            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Kelola Janji</h1>
                            <p class="mt-1 text-sm text-slate-400">Kelola dan konfirmasi janji pasien.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 sm:gap-4">
                        <p class="whitespace-nowrap text-[10px] text-slate-500 sm:hidden">{{ now()->format('d/m/Y') }}</p>
                        <p class="hidden whitespace-nowrap text-xs text-slate-500 sm:block">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</p>
                        <button type="button" aria-label="Notifikasi" class="relative flex size-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:bg-slate-50">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4" />
                            </svg>
                            <span class="absolute right-2 top-2 size-1.5 rounded-full bg-[#347cf0]"></span>
                        </button>
                        <div class="flex items-center gap-2.5 rounded-full border border-slate-200 bg-white px-2 py-1.5 shadow-sm">
                            <img src="{{ asset('img/Doctor_portrait.png') }}" alt="" class="size-9 rounded-full object-cover">
                            <div class="mr-1 leading-tight">
                                <p class="text-sm font-semibold text-slate-800">dr. Andi</p>
                                <p class="text-[11px] text-slate-400">Dokter Umum</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </header>

            <div class="px-4 py-5 sm:px-6 sm:py-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">Total Janji</p>
                                <p class="mt-3 text-3xl font-bold text-slate-900">3</p>
                            </div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#edf4ff] text-[#2a6df2]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-400">Kamis, 8 Oktober 2026</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">Menunggu Konfirmasi</p>
                                <p class="mt-3 text-3xl font-bold text-slate-900">1</p>
                            </div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff8e7] text-[#f4b63f]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-400">Perlu ditinjau</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">Dikonfirmasi</p>
                                <p class="mt-3 text-3xl font-bold text-slate-900">1</p>
                            </div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#edf7ff] text-[#2e8cff]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-400">Siap ditangani</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">Janji Selesai</p>
                                <p class="mt-3 text-3xl font-bold text-slate-900">1</p>
                            </div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eaf9f1] text-[#23b26d]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 3" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-400">Konsultasi selesai</p>
                    </div>
                </div>

                <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="grid grid-cols-1 items-end gap-4 sm:grid-cols-2 xl:grid-cols-[1.2fr_1fr_1fr_auto]">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-600">Cari pasien</label>
                            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" placeholder="Cari nama pasien..." class="w-full border-0 bg-transparent text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none" />
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-600">Tanggal janji</label>
                            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <select class="w-full appearance-none border-0 bg-transparent text-sm text-slate-700 focus:outline-none">
                                    <option>08 Okt 2026</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-600">Status</label>
                            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5">
                                <select class="w-full appearance-none border-0 bg-transparent text-sm text-slate-700 focus:outline-none">
                                    <option>Semua</option>
                                    <option>Menunggu</option>
                                    <option>Dikonfirmasi</option>
                                    <option>Selesai</option>
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#2d6ef5] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#245fe3]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-7.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>

                <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 bg-white">
                        <div class="flex items-center gap-3">
                            <h2 class="text-[18px] font-bold text-slate-900">Daftar Janji Pasien</h2>
                            <span class="inline-flex items-center rounded-full bg-[#edf4ff] px-2.5 py-1 text-xs font-semibold text-[#2d6ef5]">3 janji</span>
                        </div>
                        <p class="text-sm text-slate-400">Kamis, 8 Oktober 2026</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-500">
                                <tr>
                                    <th class="px-5 py-3 font-semibold">No.</th>
                                    <th class="px-5 py-3 font-semibold">Pasien</th>
                                    <th class="px-5 py-3 font-semibold">Tanggal</th>
                                    <th class="px-5 py-3 font-semibold">Jam</th>
                                    <th class="px-5 py-3 font-semibold">Keluhan</th>
                                    <th class="px-5 py-3 font-semibold">Status</th>
                                    <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                <tr>
                                    <td class="px-5 py-4 font-semibold text-slate-700">1</td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#eef4ff] text-[11px] font-bold text-[#2d6ef5]">BS</span>
                                            <span class="font-medium text-slate-800">Budi Santoso</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-slate-600">08 Okt 2026</td>
                                    <td class="px-5 py-4 text-slate-600">08.00</td>
                                    <td class="px-5 py-4 text-slate-600">Demam dan pusing</td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#fff7e7] px-2.5 py-1 text-xs font-semibold text-[#c98b00]">
                                            <span class="h-2 w-2 rounded-full bg-[#f4b63f]"></span>
                                            Menunggu
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" data-appointment-details data-name="Budi Santoso" data-initials="BS" data-nik="3201 •••• •••• 0042" data-phone="0812 •••• 5678" data-birth="15 Mei 1988 (38 tahun)" data-status="Menunggu" data-date="08 Okt 2026" data-time="08.00 WIB" data-complaint="Demam dan pusing" class="inline-flex items-center gap-1.5 px-2 py-2 text-xs font-semibold text-[#2d6ef5] hover:text-[#1f56c3]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12z" />
                                                    <circle cx="12" cy="12" r="2.25" />
                                                </svg>
                                                Lihat Detail
                                            </button>
                                            <button class="rounded-xl bg-[#2d6ef5] px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-[#245fe3]">Terima</button>
                                            <button class="rounded-xl border border-[#f5d4d4] bg-[#fff1f1] px-3 py-2 text-xs font-semibold text-[#d14a4a] hover:bg-[#ffe7e7]">Tolak</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-5 py-4 font-semibold text-slate-700">2</td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#f3f1ff] text-[11px] font-bold text-[#6f67ff]">SA</span>
                                            <span class="font-medium text-slate-800">Sinta Amelia</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-slate-600">08 Okt 2026</td>
                                    <td class="px-5 py-4 text-slate-600">08.30</td>
                                    <td class="px-5 py-4 text-slate-600">Batuk</td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#edf4ff] px-2.5 py-1 text-xs font-semibold text-[#2d6ef5]">
                                            <span class="h-2 w-2 rounded-full bg-[#2d6ef5]"></span>
                                            Dikonfirmasi
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <button type="button" data-appointment-details data-name="Sinta Amelia" data-initials="SA" data-nik="3273 •••• •••• 1028" data-phone="0813 •••• 2145" data-birth="23 Agustus 1994 (32 tahun)" data-status="Dikonfirmasi" data-date="08 Okt 2026" data-time="08.30 WIB" data-complaint="Batuk" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-[#2d6ef5] hover:bg-slate-50">Lihat Detail</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-5 py-4 font-semibold text-slate-700">3</td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#edf9f3] text-[11px] font-bold text-[#2aa66d]">RP</span>
                                            <span class="font-medium text-slate-800">Rina Pratiwi</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-slate-600">08 Okt 2026</td>
                                    <td class="px-5 py-4 text-slate-600">09.00</td>
                                    <td class="px-5 py-4 text-slate-600">Sakit kepala</td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#eaf9f1] px-2.5 py-1 text-xs font-semibold text-[#1da35a]">
                                            <span class="h-2 w-2 rounded-full bg-[#23b26d]"></span>
                                            Selesai
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <button type="button" data-appointment-details data-name="Rina Pratiwi" data-initials="RP" data-nik="3174 •••• •••• 8831" data-phone="0857 •••• 6902" data-birth="11 Januari 1990 (36 tahun)" data-status="Selesai" data-date="08 Okt 2026" data-time="09.00 WIB" data-complaint="Sakit kepala" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-[#2d6ef5] hover:bg-slate-50">Lihat Detail</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-200 bg-white px-5 py-4 text-sm text-slate-500">
                        <p>Menampilkan 1–3 dari 3 janji</p>
                        <div class="flex items-center gap-2">
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-400">‹</button>
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm">1</button>
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-400">›</button>
                        </div>
                    </div>
                </div>

                <div class="mt-6 rounded-2xl border border-slate-200 bg-[#edf5ff] px-4 py-3 text-sm text-slate-600">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2 text-slate-500">
                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#dfeefe] text-[#2d6ef5]">i</span>
                            <span>1 janji menunggu konfirmasi Anda.</span>
                        </div>

                        <div class="flex items-center gap-3 text-xs font-medium">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white px-2 py-1 text-slate-600">
                                <span class="h-2 w-2 rounded-full bg-[#f4b63f]"></span>
                                Status janji
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white px-2 py-1 text-slate-600">
                                <span class="h-2 w-2 rounded-full bg-[#2d6ef5]"></span>
                                Dikonfirmasi
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white px-2 py-1 text-slate-600">
                                <span class="h-2 w-2 rounded-full bg-[#23b26d]"></span>
                                Selesai
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white px-2 py-1 text-slate-600">
                                <span class="h-2 w-2 rounded-full bg-[#d14a4a]"></span>
                                Ditolak
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <div id="appointment-detail-modal" data-appointment-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4" aria-hidden="true">
            <section role="dialog" aria-modal="true" aria-labelledby="appointment-detail-title" class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">
                <header class="flex items-start justify-between border-b border-slate-200 px-5 py-4">
                    <div>
                        <h2 id="appointment-detail-title" class="text-xl font-bold text-slate-800">Detail Janji</h2>
                        <p class="mt-1 text-xs text-slate-400">Tinjau informasi pasien sebelum mengonfirmasi.</p>
                    </div>
                    <button type="button" data-close-appointment-modal aria-label="Tutup detail janji" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </header>

                <div class="space-y-4 px-5 py-5">
                    <div class="flex items-center gap-3">
                        <span data-detail-initials class="flex h-10 w-10 items-center justify-center rounded-full bg-[#eef4ff] text-sm font-bold text-[#2d6ef5]"></span>
                        <div>
                            <p class="text-xs text-slate-400">Nama pasien</p>
                            <p data-detail-name class="font-semibold text-slate-800"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <p class="text-xs text-slate-400">NIK</p>
                            <p data-detail-nik class="mt-1 font-medium text-slate-700"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">No. HP</p>
                            <p data-detail-phone class="mt-1 font-medium text-slate-700"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Tanggal lahir</p>
                            <p data-detail-birth class="mt-1 font-medium text-slate-700"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Status</p>
                            <span data-detail-status class="mt-1 inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold"></span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3 rounded-xl bg-[#edf4ff] px-4 py-3">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-[#2d6ef5]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-500">Tanggal &amp; jam janji</p>
                                <p class="text-sm font-semibold text-slate-700"><span data-detail-date></span> · <span data-detail-time></span></p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-[#2d6ef5]">dr. Andi</span>
                    </div>

                    <div>
                        <p class="mb-2 text-xs text-slate-400">Keluhan</p>
                        <p data-detail-complaint class="rounded-xl bg-slate-50 px-3 py-3 text-sm font-medium text-slate-700"></p>
                    </div>

                    <div data-pending-notice class="hidden items-start gap-2 rounded-xl bg-[#fff7e2] px-3 py-3 text-xs text-[#a87812]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Janji belum dikonfirmasi. Pilih Terima untuk menyetujui jadwal atau Tolak jika tidak dapat melayani.</span>
                    </div>
                </div>

                <footer class="border-t border-slate-200 bg-slate-50 px-5 py-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <button type="button" disabled class="inline-flex cursor-not-allowed items-center gap-2 rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-400" aria-label="Tandai selesai setelah janji dikonfirmasi">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="9" />
                                <path d="m8.5 12 2.3 2.3 4.8-5" />
                            </svg>
                            Tandai Selesai
                        </button>
                        <div class="flex items-center gap-2">
                            <button type="button" class="rounded-lg border border-[#f2caca] bg-white px-3 py-2 text-xs font-semibold text-[#d14a4a] transition hover:bg-[#fff1f1]">Tolak</button>
                            <button type="button" class="inline-flex items-center gap-1.5 rounded-lg bg-[#347cf0] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#286de0]">
                                <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m5 12 4 4L19 6" />
                                </svg>
                                Terima
                            </button>
                        </div>
                    </div>
                    <p class="mt-3 text-[11px] text-slate-500">Tandai Selesai aktif setelah janji dikonfirmasi dan konsultasi selesai.</p>
                    <p class="mt-1 text-[10px] text-slate-400">Data pribadi ilustratif · NIK dan No. HP disamarkan.</p>
                </footer>
            </section>
        </div>
    </div>
</body>
</html>
