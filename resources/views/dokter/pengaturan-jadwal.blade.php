<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Pengaturan Jadwal | ClinicOne</title>
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

                    <a href="{{ route('dokter.janji') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Kelola Janji
                    </a>

                    <a href="{{ route('dokter.jadwal') }}" class="flex items-center gap-3 rounded-xl border-r-2 border-[#4a86ff] bg-[#edf4ff] px-3 py-2.5 text-sm font-semibold text-[#2c6efb] transition-colors">
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
                        <span class="h-2 w-2 rounded-full {{ $isOpenToday ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                        <p class="text-[11px] font-semibold text-slate-700">{{ $isOpenToday ? 'Klinik siap melayani' : 'Klinik tutup hari ini' }}</p>
                    </div>
                    <p class="pl-4 text-[10px] text-slate-400">
                        {{ $todaySchedule?->is_open ? 'Jam praktik '.substr($todaySchedule->start_time, 0, 5).' – '.substr($todaySchedule->end_time, 0, 5) : 'Tidak ada jadwal praktik hari ini' }}
                    </p>
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

        <main data-doctor-main class="ml-0 min-w-0 flex-1 px-4 py-6 md:ml-[184px] md:px-6">
            <header class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                <div class="flex min-w-0 items-start gap-3">
                    <button type="button" data-doctor-sidebar-toggle aria-controls="doctor-sidebar" aria-expanded="false" aria-label="Buka menu" class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <p class="text-[13px] font-medium text-slate-400">Manajemen pasien</p>
                        <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Pengaturan Jadwal</h1>
                        <p class="mt-1 text-sm text-slate-400">Atur jadwal praktik dan ketersediaan waktu dokter.</p>
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

            @if (session('schedule_success'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">
                    {{ session('schedule_success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800" role="alert">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="mb-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#eef5ff] text-[#2c6efb]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5a7 7 0 00-7 7h14a7 7 0 00-7-7zm-7 7h14M12 5v14" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-base font-bold text-slate-700">Status Praktik</span>
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-1 text-base font-bold {{ $isOpenToday ? 'bg-[#eaf9f1] text-[#1da86b]' : 'bg-slate-100 text-slate-500' }}">
                                        <span class="h-2 w-2 rounded-full {{ $isOpenToday ? 'bg-[#2aa66d]' : 'bg-slate-400' }}"></span>
                                        {{ $isOpenToday ? 'OPEN' : 'CLOSED' }}
                                </span>
                            </div>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $isScheduledToday ? 'Jadwal mingguan: '.substr($weeklySchedules->get($today->dayOfWeekIso)->start_time, 0, 5).' – '.substr($weeklySchedules->get($today->dayOfWeekIso)->end_time, 0, 5) : 'Hari ini libur sesuai jadwal mingguan.' }}
                                    @if (! $isOpenToday && $isScheduledToday)
                                        Penerimaan janji ditutup untuk hari ini.
                                    @endif
                                </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 p-1">
                        @if ($isScheduledToday)
                                <form method="POST" action="{{ route('dokter.jadwal.status') }}">
                                    @csrf
                                    <input type="hidden" name="status" value="open">
                                    <button type="submit" @disabled($isOpenToday) class="rounded-lg px-4 py-2 text-sm font-semibold shadow-sm disabled:cursor-default {{ $isOpenToday ? 'bg-[#2d6ef5] text-white' : 'text-slate-600 hover:bg-white' }}">Open</button>
                                </form>
                                <form method="POST" action="{{ route('dokter.jadwal.status') }}">
                                    @csrf
                                    <input type="hidden" name="status" value="closed">
                                    <button type="submit" @disabled(! $isOpenToday) class="rounded-lg px-4 py-2 text-sm font-medium disabled:cursor-default {{ ! $isOpenToday ? 'bg-white text-slate-700 shadow-sm' : 'text-slate-600 hover:bg-white' }}">Close</button>
                                </form>
                        @else
                                <button type="button" disabled class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-400">Hari ini libur</button>
                        @endif
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-4 py-4 sm:px-5">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Jadwal Praktik Mingguan</h2>
                        <p class="mt-1 text-xs text-slate-400">Jadwal rutin dokter setiap minggu.</p>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $practiceDayCount }} hari praktik
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Hari</th>
                                <th class="px-5 py-3 font-semibold">Jam Praktik</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach ($days as $dayOfWeek => $dayName)
                                @php
                                    $schedule = $weeklySchedules->get($dayOfWeek);
                                    $isOpen = $schedule?->is_open === true;
                                    $startTime = $schedule?->start_time ? substr($schedule->start_time, 0, 5) : '';
                                    $endTime = $schedule?->end_time ? substr($schedule->end_time, 0, 5) : '';
                                @endphp
                                <tr>
                                    <td class="px-5 py-4 font-medium text-slate-700">{{ $dayName }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <input type="hidden" name="schedule[{{ $dayOfWeek }}][is_open]" value="0" form="weekly-schedule-form">
                                            <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                                                <input type="checkbox" name="schedule[{{ $dayOfWeek }}][is_open]" value="1" form="weekly-schedule-form" @checked(old("schedule.$dayOfWeek.is_open", $isOpen)) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                Praktik
                                            </label>
                                            <input type="time" name="schedule[{{ $dayOfWeek }}][start_time]" value="{{ old("schedule.$dayOfWeek.start_time", $startTime) }}" form="weekly-schedule-form" class="rounded-lg border border-slate-200 px-2 py-1.5 text-sm text-slate-700">
                                            <span class="text-xs text-slate-400">s.d.</span>
                                            <input type="time" name="schedule[{{ $dayOfWeek }}][end_time]" value="{{ old("schedule.$dayOfWeek.end_time", $endTime) }}" form="weekly-schedule-form" class="rounded-lg border border-slate-200 px-2 py-1.5 text-sm text-slate-700">
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $isOpen ? 'bg-[#eaf9f1] text-[#2aa66d]' : 'bg-[#eef4ff] text-[#4e6cda]' }}">
                                            <span class="h-2 w-2 rounded-full {{ $isOpen ? 'bg-[#2aa66d]' : 'bg-[#4e6cda]' }}"></span>
                                            {{ $isOpen ? 'Aktif' : 'Libur' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col items-start justify-between gap-3 border-t border-slate-200 px-4 py-4 sm:flex-row sm:items-center sm:px-5">
                    <p class="text-sm text-slate-500">Jadwal baru berlaku setelah disimpan. Perubahan yang berbenturan dengan janji aktif akan ditolak.</p>
                    <button type="submit" form="weekly-schedule-form" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#2d6ef5] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#245fe3]">
                        Simpan Jadwal
                    </button>
                </div>
            </section>

            <form id="weekly-schedule-form" method="POST" action="{{ route('dokter.jadwal.update') }}">
                @csrf
            </form>

            <section class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <h3 class="text-[18px] font-bold text-slate-900">Ketersediaan Hari Ini</h3>
                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">{{ $availableSlotCount }} tersedia · {{ $reservedSlotCount }} terisi</span>
                    </div>
                    <p class="text-sm text-slate-400">{{ $today->locale('id')->translatedFormat('l, j F Y') }}</p>
                </div>

                @if ($slotAvailability->isEmpty())
                    <p class="rounded-xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                        {{ $isOpenToday ? 'Tidak ada slot tersisa untuk hari ini.' : 'Tidak ada slot praktik yang dibuka hari ini.' }}
                    </p>
                @else
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-6">
                        @foreach ($slotAvailability as $slot)
                            @php
                                $slotIsAvailable = $isOpenToday && ! $slot['is_reserved'] && ! $slot['is_expired'];
                                $slotClasses = $slot['is_reserved']
                                    ? 'border-[#dfe7f4] bg-[#f3f7ff] text-[#4a6bb8]'
                                    : ($slotIsAvailable ? 'border-[#cfe9df] bg-[#eaf9f1] text-[#1da35a]' : 'border-slate-200 bg-slate-50 text-slate-500');
                            @endphp
                            <div class="rounded-xl border p-3 text-center {{ $slotClasses }}">
                                <p class="text-[13px] font-bold text-slate-800">{{ str_replace(':', '.', $slot['time']) }}</p>
                                <p class="mt-1 text-[11px] font-medium">
                                    {{ $slot['is_reserved'] ? 'Sudah ada janji' : ($slot['is_expired'] ? 'Sudah lewat' : ($slotIsAvailable ? 'Tersedia' : 'Ditutup')) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-5 flex flex-col items-start justify-between gap-3 border-t border-slate-200 pt-4 sm:flex-row sm:items-center">
                    <p class="text-sm text-slate-500">Menampilkan slot sesuai jadwal praktik dan janji pasien hari ini.</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
