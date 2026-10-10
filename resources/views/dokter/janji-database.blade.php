<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Kelola Janji | ClinicOne</title>
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
                        <p class="text-sm font-bold leading-none text-slate-900">ClinicOne</p>
                        <p class="mt-0.5 text-[10px] text-slate-400">Klinik Umum</p>
                    </div>
                </div>

                <p class="mb-3 text-[10px] font-semibold uppercase tracking-widest text-slate-400">Menu utama</p>
                <nav class="space-y-1">
                    <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5M5 9v11h14V9M9 20v-6h6v6" />
                        </svg>
                        Beranda
                    </a>
                    <a href="{{ route('dokter.janji') }}" aria-current="page" class="flex items-center gap-3 rounded-lg border-r-2 border-blue-600 bg-blue-50 px-3 py-2.5 text-sm font-semibold text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Kelola Janji
                    </a>
                    <a href="{{ route('dokter.jadwal') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3m8-3v3M4 7h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1zm4 7 1.5 1.5L13 11" />
                        </svg>
                        Pengaturan Jadwal
                    </a>
                    <a href="{{ route('dokter.profil') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Profil Dokter
                    </a>
                </nav>
            </div>

            <div>
                <div class="mb-4 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                    <div class="mb-0.5 flex items-center gap-2">
                        <span class="h-2 w-2 shrink-0 rounded-full bg-emerald-500"></span>
                        <p class="text-xs font-semibold text-slate-700">Klinik siap melayani</p>
                    </div>
                    <p class="pl-4 text-[11px] text-slate-400">Jam praktik 08.00 – 12.00</p>
                </div>
                <form method="POST" action="{{ route('dokter.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-500 transition-colors hover:bg-slate-50 hover:text-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-blue-600">Manajemen pasien</p>
                        <h1 class="mt-0.5 text-2xl font-bold text-slate-900">Kelola Janji</h1>
                        <p class="mt-0.5 text-sm text-slate-400">Tinjau, konfirmasi, dan perbarui janji pasien.</p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 sm:gap-4">
                    <p class="whitespace-nowrap text-[10px] text-slate-500 sm:hidden">{{ \Carbon\CarbonImmutable::now(\App\Models\Appointment::TIMEZONE)->format('d/m/Y') }}</p>
                    <p class="hidden whitespace-nowrap text-xs text-slate-500 sm:block">{{ \Carbon\CarbonImmutable::now(\App\Models\Appointment::TIMEZONE)->locale('id')->translatedFormat('l, j F Y') }}</p>
                    <div class="flex items-center gap-2.5 rounded-full border border-slate-200 bg-white px-2 py-1.5 shadow-sm">
                        <img src="{{ $profile?->photo_path ? route('dokter.profil.photo') : asset('img/Doctor_portrait.png') }}" alt="" class="size-9 rounded-full object-cover">
                        <div class="mr-1 leading-tight">
                            <p class="text-sm font-semibold text-slate-800">{{ $profile?->full_name ? trim(($profile->title ? $profile->title.' ' : '').$profile->full_name) : 'dr. Andi' }}</p>
                            <p class="text-[11px] text-slate-400">{{ $profile?->specialization ?: 'Dokter Umum' }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </header>

            <div class="flex-1 space-y-5 px-4 py-5 sm:px-6 sm:py-6">
                @if (session('appointment_success'))
                    <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('appointment_success') }}</div>
                @endif
                @if ($errors->any())
                    <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Ringkasan janji">
                    @foreach ([
                        ['key' => 'total', 'label' => 'Total Janji', 'detail' => 'Semua janji terdaftar', 'icon' => 'calendar', 'color' => 'blue'],
                        ['key' => 'pending', 'label' => 'Menunggu Konfirmasi', 'detail' => 'Perlu ditinjau', 'icon' => 'clock', 'color' => 'amber'],
                        ['key' => 'confirmed', 'label' => 'Dikonfirmasi', 'detail' => 'Siap ditangani', 'icon' => 'check-circle', 'color' => 'blue'],
                        ['key' => 'completed', 'label' => 'Janji Selesai', 'detail' => 'Konsultasi selesai', 'icon' => 'check', 'color' => 'emerald'],
                    ] as $card)
                        <article class="flex items-start justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                            <div>
                                <h2 class="text-sm text-slate-500">{{ $card['label'] }}</h2>
                                <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900">{{ $stats[$card['key']] }}</p>
                                <p class="mt-2 text-xs text-slate-400">{{ $card['detail'] }}</p>
                            </div>
                            <div @class([
                                'mt-0.5 shrink-0 rounded-xl p-2.5',
                                'bg-blue-50 text-blue-500' => $card['color'] === 'blue',
                                'bg-amber-50 text-amber-500' => $card['color'] === 'amber',
                                'bg-emerald-50 text-emerald-500' => $card['color'] === 'emerald',
                            ])>
                                @if ($card['icon'] === 'calendar')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @elseif ($card['icon'] === 'clock')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif ($card['icon'] === 'check-circle')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </section>

                <form method="GET" action="{{ route('dokter.janji') }}" class="grid grid-cols-1 items-end gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)_minmax(0,1fr)_auto] sm:p-5">
                    <div>
                        <label for="appointment-search" class="mb-1.5 block text-sm font-medium text-slate-700">Cari pasien</label>
                        <input id="appointment-search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama atau email" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="appointment-date" class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal janji</label>
                        <input id="appointment-date" name="date" type="date" value="{{ $filters['date'] ?? '' }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="appointment-status" class="mb-1.5 block text-sm font-medium text-slate-700">Status</label>
                        <select id="appointment-status" name="status" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="all" @selected(($filters['status'] ?? 'all') === 'all')>Semua status</option>
                            @foreach ([
                                'pending' => 'Menunggu',
                                'confirmed' => 'Dikonfirmasi',
                                'rejected' => 'Ditolak',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ] as $value => $label)
                                <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-[#2d6ef5] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#245fe3] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-7.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                </form>

                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" aria-labelledby="appointments-table-title">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-4 py-4 sm:px-5">
                        <div class="flex items-center gap-3">
                            <h2 id="appointments-table-title" class="text-base font-bold text-slate-900 sm:text-lg">Daftar Janji Pasien</h2>
                            <span class="rounded-full bg-[#edf4ff] px-2.5 py-1 text-xs font-semibold text-[#2d6ef5]">{{ $appointments->total() }} janji</span>
                        </div>
                        <p class="whitespace-nowrap text-xs text-slate-400">{{ \Carbon\CarbonImmutable::now(\App\Models\Appointment::TIMEZONE)->locale('id')->translatedFormat('l, j F Y') }}</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-[980px] w-full text-left text-sm">
                            <thead class="border-b border-slate-100 bg-slate-50 text-slate-500">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold sm:px-5">No.</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold sm:px-5">Pasien</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold sm:px-5">Tanggal</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold sm:px-5">Jam</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold sm:px-5">Keluhan</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold sm:px-5">Status</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold sm:px-5">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($appointments as $appointment)
                                    @php
                                        $patient = $appointment->patient;
                                        $patientName = $patient?->name ?? 'Pasien tidak terdaftar';
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'confirmed' => 'Dikonfirmasi',
                                            'rejected' => 'Ditolak',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                        $statusLabel = $statusLabels[$appointment->status] ?? $appointment->status;
                                        $statusClasses = match ($appointment->status) {
                                            'pending' => 'bg-amber-50 text-amber-700',
                                            'confirmed' => 'bg-blue-50 text-blue-700',
                                            'completed' => 'bg-emerald-50 text-emerald-700',
                                            'rejected', 'cancelled' => 'bg-rose-50 text-rose-700',
                                            default => 'bg-slate-100 text-slate-600',
                                        };
                                    @endphp
                                    <tr class="transition-colors hover:bg-slate-50">
                                        <td class="px-4 py-4 font-medium text-slate-500 sm:px-5">{{ $appointments->firstItem() + $loop->index }}</td>
                                        <td class="px-4 py-4 sm:px-5">
                                            <div class="flex items-center gap-3">
                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-[11px] font-bold text-blue-600">{{ mb_substr(mb_strtoupper($patientName), 0, 2) }}</span>
                                                <span class="font-medium text-slate-800">{{ $patientName }}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-slate-600 sm:px-5">{{ $appointment->appointment_date->locale('id')->translatedFormat('d M Y') }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-slate-600 sm:px-5">{{ substr($appointment->appointment_time, 0, 5) }}</td>
                                        <td class="max-w-xs truncate px-4 py-4 text-slate-600 sm:px-5">{{ $appointment->complaint }}</td>
                                        <td class="px-4 py-4 sm:px-5">
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 sm:px-5">
                                            <div class="flex min-w-max flex-wrap items-center justify-end gap-2">
                                                <button type="button"
                                                    data-appointment-details
                                                    data-name="{{ $patientName }}"
                                                    data-initials="{{ mb_substr(mb_strtoupper($patientName), 0, 1) }}"
                                                    data-nik="{{ $patient?->nik ? substr($patient->nik, 0, 4).'•••• •••• '.substr($patient->nik, -4) : '-' }}"
                                                    data-phone="{{ $patient?->phone ? mb_substr($patient->phone, 0, 3).'••••'.mb_substr($patient->phone, -4) : '-' }}"
                                                    data-birth="{{ $patient?->birth_date?->locale('id')->translatedFormat('j F Y') ?? '-' }}"
                                                    data-status="{{ $statusLabel }}"
                                                    data-date="{{ $appointment->appointment_date->locale('id')->translatedFormat('d M Y') }}"
                                                    data-time="{{ substr($appointment->appointment_time, 0, 5) }} WIB"
                                                    data-complaint="{{ $appointment->complaint }}"
                                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-[#2d6ef5] transition hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat Detail
                                                </button>

                                                @if ($appointment->status === 'pending')
                                                    <form method="POST" action="{{ route('dokter.janji.status', $appointment) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="rounded-lg bg-[#2d6ef5] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#245fe3]">Terima</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('dokter.janji.status', $appointment) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">Tolak</button>
                                                    </form>
                                                @elseif ($appointment->status === 'confirmed' && $appointment->canBeMarkedCompleted())
                                                    <form method="POST" action="{{ route('dokter.janji.status', $appointment) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">Tandai selesai</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-10 text-center text-sm text-slate-400 sm:px-5">Belum ada janji yang sesuai dengan filter.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="border-t border-slate-200 px-4 py-3 sm:px-5">
                        {{ $appointments->links() }}
                    </div>
                </section>
            </div>
        </main>

        <div id="appointment-detail-modal" data-appointment-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4" aria-hidden="true">
            <section role="dialog" aria-modal="true" aria-labelledby="appointment-detail-title" class="w-full max-w-lg rounded-2xl bg-white p-5 shadow-2xl">
                <div class="mb-4 flex items-center justify-between">
                    <h2 id="appointment-detail-title" class="text-xl font-bold text-slate-900">Detail Janji</h2>
                    <button type="button" data-close-appointment-modal aria-label="Tutup detail janji" class="rounded-lg px-3 py-2 text-slate-500 transition hover:bg-slate-100">Tutup</button>
                </div>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-slate-400">Nama pasien</dt>
                        <dd class="mt-1 flex items-center gap-2 font-semibold text-slate-800"><span data-detail-initials class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-xs text-blue-600"></span><span data-detail-name></span></dd>
                    </div>
                    <div><dt class="text-slate-400">Status</dt><dd data-detail-status class="mt-1 font-semibold"></dd></div>
                    <div><dt class="text-slate-400">NIK</dt><dd data-detail-nik class="mt-1 text-slate-700"></dd></div>
                    <div><dt class="text-slate-400">No. HP</dt><dd data-detail-phone class="mt-1 text-slate-700"></dd></div>
                    <div><dt class="text-slate-400">Tanggal lahir</dt><dd data-detail-birth class="mt-1 text-slate-700"></dd></div>
                    <div><dt class="text-slate-400">Jadwal</dt><dd class="mt-1 text-slate-700"><span data-detail-date></span> · <span data-detail-time></span></dd></div>
                    <div class="col-span-2"><dt class="text-slate-400">Keluhan</dt><dd data-detail-complaint class="mt-1 whitespace-pre-wrap text-slate-700"></dd></div>
                </dl>
                <div data-pending-notice class="mt-4 hidden items-center gap-2 rounded-lg bg-amber-50 px-3 py-2 text-xs text-amber-800">
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                    Janji ini menunggu konfirmasi dokter.
                </div>
            </section>
        </div>
    </div>
</body>
</html>
