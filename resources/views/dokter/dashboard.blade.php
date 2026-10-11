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
        <aside id="doctor-sidebar" data-doctor-sidebar class="fixed inset-y-0 left-0 z-40 flex w-[184px] -translate-x-full flex-col justify-between border-r border-slate-200 bg-white px-3.5 py-6 transition-transform duration-300 ease-in-out md:translate-x-0">
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
                        Pengaturan Jadwal
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

        <main data-doctor-main class="ml-0 flex min-h-screen min-w-0 flex-1 flex-col md:ml-[184px]">
            <header class="flex flex-col justify-between gap-4 border-b border-slate-200 bg-white px-4 py-4 sm:flex-row sm:items-center sm:px-8">
                <div class="flex min-w-0 items-start gap-3">
                    <button type="button" data-doctor-sidebar-toggle aria-controls="doctor-sidebar" aria-expanded="false" aria-label="Buka menu" class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Beranda</p>
                        <h1 class="text-2xl font-bold text-slate-900 mt-0.5">Selamat pagi, {{ $doctorDisplayName }}</h1>
                        <p class="text-sm text-slate-400 mt-0.5">Berikut ringkasan aktivitas klinik hari ini.</p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 sm:gap-4">
                    <p class="whitespace-nowrap text-[10px] text-slate-500 sm:hidden">{{ now()->format('d/m/Y') }}</p>
                    <p class="hidden whitespace-nowrap text-xs text-slate-500 sm:block">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</p>
                    <div class="flex items-center gap-2.5 rounded-full border border-slate-200 bg-white px-2 py-1.5 shadow-sm">
                        <img src="{{ $profile?->photo_path ? route('dokter.profil.photo') : asset('img/Doctor_portrait.png') }}" alt="" class="size-9 rounded-full object-cover">
                        <div class="mr-1 leading-tight">
                            <p class="text-sm font-semibold text-slate-800">{{ $doctorDisplayName }}</p>
                            <p class="text-[11px] text-slate-400">{{ $doctorSpecialization }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </header>

            <div class="flex-1 space-y-6 px-4 py-5 sm:px-6 sm:py-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="flex items-start justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div>
                            <p class="text-sm text-slate-500">Janji Hari Ini</p>
                            <p class="mt-2 text-4xl font-bold text-slate-900">{{ $appointmentCount }}</p>
                            <p class="mt-1 text-xs text-slate-400">Total janji terjadwal</p>
                        </div>
                        <div class="rounded-lg bg-blue-50 p-2 text-blue-500 shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-start justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div>
                            <p class="text-sm text-slate-500">Menunggu Konfirmasi</p>
                            <p class="mt-2 text-4xl font-bold text-slate-900">{{ $waitingAppointmentCount }}</p>
                            <p class="mt-1 text-xs text-slate-400">Perlu ditinjau</p>
                        </div>
                        <div class="rounded-lg bg-amber-50 p-2 text-amber-500 shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-start justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div>
                            <p class="text-sm text-slate-500">Janji Selesai</p>
                            <p class="mt-2 text-4xl font-bold text-slate-900">{{ $completedAppointmentCount }}</p>
                            <p class="mt-1 text-xs text-slate-400">Konsultasi selesai</p>
                        </div>
                        <div class="rounded-lg bg-sky-50 p-2 text-sky-500 shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-start justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div>
                            <p class="text-sm text-slate-500">Slot Tersedia</p>
                            <p class="mt-2 text-4xl font-bold text-slate-900">{{ $availableSlotCount }}</p>
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
                    class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5"
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

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Jadwal Mendatang</h2>
                            <p class="text-xs text-slate-400 mt-0.5">10 janji terdekat, mulai hari ini.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                    <table class="w-full min-w-[620px] text-sm">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-6">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-6">Jam</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Pasien</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($appointments as $appointment)
                                @php
                                    [$statusLabel, $statusClasses] = match ($appointment->status) {
                                        'pending' => ['Menunggu', 'bg-amber-50 border-amber-200 text-amber-700'],
                                        'confirmed' => ['Dikonfirmasi', 'bg-emerald-50 border-emerald-200 text-emerald-700'],
                                        'completed' => ['Selesai', 'bg-sky-50 border-sky-200 text-sky-700'],
                                        'cancelled' => ['Dibatalkan', 'bg-slate-50 border-slate-200 text-slate-500'],
                                        default => [$appointment->status, 'bg-slate-50 border-slate-200 text-slate-500'],
                                    };
                                    $patientName = $appointment->patient?->name ?? 'Pasien tidak terdaftar';
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-4 text-slate-600 sm:px-6">{{ $appointment->appointment_date->locale('id')->translatedFormat('j M Y') }}</td>
                                    <td class="px-4 py-4 font-semibold text-slate-800 sm:px-6">{{ substr($appointment->appointment_time, 0, 5) }}</td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-sky-100 flex items-center justify-center text-xs font-bold text-sky-700 shrink-0">{{ mb_substr(mb_strtoupper($patientName), 0, 2) }}</div>
                                            <span class="font-medium text-slate-800">{{ $patientName }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-right sm:px-6">
                                        <button type="button" class="rounded-lg border border-slate-200 px-4 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Detail</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-400 sm:px-6">Belum ada janji temu mendatang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
