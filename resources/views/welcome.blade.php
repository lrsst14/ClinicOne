<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'ClinicOne') }} — Dashboard</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-slate-950 font-sans text-slate-100 antialiased">
        <main class="mx-auto flex min-h-screen w-full max-w-6xl flex-col gap-10 px-6 py-10 sm:px-10">
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-800 pb-6">
                <a href="{{ url('/') }}" class="text-xl font-semibold tracking-tight text-white">
                    Clinic<span class="text-sky-400">One</span>
                </a>
                <span class="rounded-full border border-slate-700 px-3 py-1 text-xs font-medium uppercase tracking-[0.18em] text-slate-400">
                    Dashboard
                </span>
            </header>

            <section
                data-registration-chart
                data-endpoint="{{ route('dashboard.registration-chart') }}"
                class="w-full max-w-4xl"
                aria-labelledby="registration-chart-title"
            >
                <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="mb-2 text-sm font-medium text-sky-400">Aktivitas akun</p>
                        <h1 id="registration-chart-title" class="text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                            Pendaftaran akun
                        </h1>
                        <p class="mt-2 text-sm text-slate-400">Jumlah akun baru setiap hari selama 7 hari terakhir.</p>
                    </div>
                    <div class="min-w-36 rounded-xl border border-slate-800 bg-slate-900/70 px-5 py-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Total 7 hari</p>
                        <p id="registration-total" class="mt-1 text-3xl font-semibold tabular-nums text-white" aria-live="polite">—</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-4 shadow-2xl shadow-black/10 sm:p-7">
                    <div class="mb-4 flex items-center gap-2">
                        <span class="relative flex size-2">
                            <span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-50"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-emerald-400"></span>
                        </span>
                        <p id="registration-chart-status" class="text-xs text-slate-400" role="status" aria-live="polite">
                            Memuat data pendaftaran...
                        </p>
                    </div>

                    <svg
                        class="h-auto w-full overflow-visible text-sky-400"
                        viewBox="0 0 700 260"
                        role="img"
                        aria-label="Grafik jumlah pendaftaran akun selama tujuh hari terakhir"
                        data-chart-svg
                    ></svg>
                </div>
            </section>
        </main>
    </body>
</html>
