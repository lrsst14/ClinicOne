<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Profil Dokter | ClinicOne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f4f7] font-sans text-slate-800 antialiased">
    <div class="flex min-h-screen">
        <aside id="doctor-sidebar" data-doctor-sidebar class="fixed inset-y-0 left-0 z-40 flex w-[184px] -translate-x-full flex-col justify-between border-r border-slate-200 bg-white px-3.5 py-6 transition-transform duration-300 ease-in-out md:translate-x-0">
            <div>
                <a href="{{ route('dokter.dashboard') }}" class="mb-8 flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#296cff] text-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 3h6v6h6v6h-6v6H9v-6H3V9h6z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[15px] font-bold leading-none text-slate-900">ClinicOne</p>
                        <p class="mt-1 text-[10px] text-slate-400">Klinik Umum</p>
                    </div>
                </a>

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
                    <a href="{{ route('dokter.jadwal') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3m8-3v3M4 7h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1zm4 7 1.5 1.5L13 11" />
                        </svg>
                        Pengaturan Jadwal
                    </a>
                    <a href="{{ route('dokter.profil') }}" aria-current="page" class="flex items-center gap-3 rounded-xl border-r-2 border-[#4a86ff] bg-[#edf4ff] px-3 py-2.5 text-sm font-semibold text-[#2c6efb]">
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

        <main data-doctor-main class="ml-0 min-w-0 flex-1 px-4 py-6 md:ml-[184px] md:px-6">
            <header class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                <div class="flex min-w-0 items-start gap-3">
                    <button type="button" data-doctor-sidebar-toggle aria-controls="doctor-sidebar" aria-expanded="false" aria-label="Buka menu" class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Profil Dokter</h1>
                        <p class="mt-1 text-sm text-slate-400">Kelola informasi profil dokter yang ditampilkan kepada pasien.</p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 sm:gap-4">
                    <p class="whitespace-nowrap text-[10px] text-slate-500 sm:hidden">{{ now()->format('d/m/Y') }}</p>
                    <p class="hidden whitespace-nowrap text-xs text-slate-500 sm:block">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</p>
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
            </header>

            <section class="mb-5 flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:gap-5 sm:p-5">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('img/Doctor_portrait.png') }}" alt="Foto dr. Andi Pratama" class="size-[72px] rounded-full object-cover sm:size-[80px]">
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="text-xl font-bold text-slate-800">dr. Andi Pratama</h2>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#eaf9f1] px-2.5 py-1 text-xs font-semibold text-[#249d66]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#27ad72]"></span>
                                Praktik Aktif
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-slate-600">Dokter Umum</p>
                        <p class="mt-1 flex items-center gap-1.5 text-xs text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18m6 0V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01" />
                            </svg>
                            TemuDok — Klinik Umum
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-start gap-2 sm:items-end">
                    <label for="doctor-photo" class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#2d6ef5]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8a2 2 0 012-2h2l2-2h6l2 2h2a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                            <circle cx="12" cy="13" r="3" />
                        </svg>
                        Ubah Foto
                    </label>
                    <input id="doctor-photo" type="file" accept="image/jpeg,image/png" class="sr-only">
                    <p class="text-[11px] text-slate-400">JPG atau PNG, maks. 2 MB</p>
                </div>
            </section>

            <section class="mb-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <h2 class="mb-4 text-base font-bold text-slate-800">Informasi Dokter</h2>
                <div class="grid grid-cols-1 gap-x-4 gap-y-3 md:grid-cols-2">
                    <label class="block text-xs font-medium text-slate-600">
                        Nama Lengkap
                        <input type="text" value="Andi Pratama" class="mt-1.5 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-normal text-slate-700 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                    </label>
                    <div class="grid grid-cols-[0.55fr_1.45fr] gap-3">
                        <label class="block text-xs font-medium text-slate-600">
                            Gelar
                            <input type="text" value="dr." class="mt-1.5 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-normal text-slate-700 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                        </label>
                        <label class="block text-xs font-medium text-slate-600">
                            Spesialisasi
                            <input type="text" value="Dokter Umum" class="mt-1.5 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-normal text-slate-700 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                        </label>
                    </div>
                    <label class="block text-xs font-medium text-slate-600">
                        No. STR
                        <input type="text" value="1234567890123456" class="mt-1.5 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-normal text-slate-700 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                    </label>
                    <label class="block text-xs font-medium text-slate-600">
                        No. SIP
                        <input type="text" value="001/SIP-DU/2026" class="mt-1.5 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-normal text-slate-700 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                    </label>
                    <label class="block text-xs font-medium text-slate-600">
                        No. Telepon
                        <input type="tel" value="0812 3456 7890" class="mt-1.5 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-normal text-slate-700 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                    </label>
                    <label class="block text-xs font-medium text-slate-600">
                        Email
                        <input type="email" value="andi.pratama@example.com" class="mt-1.5 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-normal text-slate-700 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                    </label>
                </div>
                <p class="mt-3 text-[11px] text-slate-400">Nomor STR, SIP, dan kontak di atas merupakan data contoh fiktif.</p>
            </section>

            <section class="mb-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <h2 class="mb-3 text-base font-bold text-slate-800">Tentang Dokter</h2>
                <label class="block text-xs font-medium text-slate-600">
                    Deskripsi Singkat
                    <textarea rows="2" class="mt-1.5 block w-full resize-y rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-normal text-slate-700 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">Dokter umum yang memberikan layanan konsultasi dan pemeriksaan kesehatan umum.</textarea>
                </label>
            </section>

            <section class="mb-5 flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4ff] text-[#2d6ef5]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-800">Keamanan Akun</h2>
                        <p class="mt-1 text-xs text-slate-400">Email akun <span class="ml-2 font-medium text-slate-600">andi.pratama@example.com</span></p>
                    </div>
                </div>
                <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#2d6ef5]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a3 3 0 11-5.83 1H3v4h3v3h3v-3h2.17A3 3 0 0015 7z" />
                    </svg>
                    Ubah Password
                </button>
            </section>

            <footer class="flex flex-col items-start justify-between gap-4 pb-2 sm:flex-row sm:items-center">
                <p class="flex items-center gap-2 text-xs text-slate-500">
                    <span class="flex h-4 w-4 items-center justify-center rounded-full border border-slate-400 text-[10px] font-semibold">i</span>
                    Perubahan profil berlaku setelah disimpan.
                </p>
                <div class="flex items-center gap-2">
                    <button type="button" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</button>
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg bg-[#2d6ef5] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#245fe3]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 3" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </footer>
        </main>
    </div>
</body>
</html>
