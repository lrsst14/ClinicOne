<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Login Dokter | ClinicOne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 min-h-screen font-sans text-slate-800 antialiased">
    <main class="grid min-h-screen grid-cols-1 min-[761px]:grid-cols-[minmax(340px,47.3%)_minmax(0,1fr)]">
        <section class="flex min-h-0 flex-col bg-[#edf5ff] px-[clamp(22px,6vw,40px)] pt-5 pb-[18px] min-[761px]:min-h-screen min-[761px]:px-[9%] min-[761px]:py-[29px]">
            <a href="{{ route('home') }}" class="flex w-fit items-center gap-2.5 no-underline" aria-label="ClinicOne, halaman utama">
                <span class="flex size-[25px] items-center justify-center rounded-[6px] bg-[#347cf0] text-white min-[761px]:size-[34px]">
                    <svg viewBox="0 0 24 24" class="size-[17px] min-[761px]:size-[21px]" fill="none" aria-hidden="true">
                        <path d="M9 4h6v5h5v6h-5v5H9v-5H4V9h5V4Z" fill="currentColor" />
                    </svg>
                </span>
                <span class="flex flex-col leading-[1.1]">
                    <span class="text-[19px] font-bold tracking-[-0.04em] text-[#263b59]">ClinicOne</span>
                    <span class="mt-[3px] text-[11px] leading-none text-[#8092ad]">Klinik Umum</span>
                </span>
            </a>

            <div class="mx-auto flex w-full grow flex-col items-center justify-center py-[13px] text-center min-[761px]:max-w-[440px] min-[761px]:gap-[19px] min-[761px]:py-4">
                <img src="{{ asset('img/Doctor.png') }}" alt="Ilustrasi dokter menyambut" class="block max-h-[185px] w-[min(65%,230px)] object-contain max-[420px]:max-h-[150px] max-[420px]:w-[min(62%,190px)] min-[761px]:max-h-[45vh] min-[761px]:w-full min-[761px]:max-w-[360px]">
                <div class="mt-[9px] flex flex-col gap-1.5 min-[761px]:mt-0 min-[761px]:gap-2.5">
                    <h1 class="text-[25px] font-bold leading-tight tracking-[-0.045em] text-[#263b59] max-[420px]:text-[23.8px] min-[761px]:text-[clamp(25px,2vw,32.5px)]">Selamat Datang di ClinicOne</h1>
                    <p class="text-[13.8px] text-[#7c8da7] min-[761px]:text-[16.3px]">Kelola layanan klinik dan jadwal pasien dengan mudah.</p>
                </div>
            </div>
        </section>

        <section class="flex min-h-0 flex-col justify-center bg-[#f3f7fd] px-[clamp(22px,6vw,40px)] py-8 min-[761px]:min-h-screen min-[761px]:px-8 min-[761px]:py-10">
            <div class="doctor-login-enter my-auto w-full max-w-[360px] self-center rounded-xl border border-[#edf1f6] bg-white px-7 py-7 shadow-[0_12px_36px_rgba(35,66,112,0.07)] sm:px-[30px] sm:py-[30px]">
                <span class="mb-5 flex size-10 items-center justify-center rounded-lg bg-[#edf4ff] text-[#347cf0]" aria-hidden="true">
                    <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="10" width="16" height="11" rx="2" />
                        <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                        <circle cx="12" cy="15" r="1" />
                    </svg>
                </span>
                <h2 class="text-[24px] font-bold leading-[1.2] tracking-[-0.035em] text-[#263b59]">Login Dokter</h2>
                <p class="doctor-login-intro mb-6 mt-2 text-[12px] leading-[1.5] text-[#7c8da7]">Masuk untuk mengelola layanan klinik.</p>

                <form method="POST" action="{{ route('dokter.login.submit') }}" class="doctor-login-form grid gap-[10px]" data-doctor-login-form novalidate>
                    @csrf
                    <div class="doctor-login-field grid gap-[5px]">
                        <label for="access-code" class="text-[11px] font-semibold text-[#334763]">Kode Akses</label>
                        <div class="doctor-login-input-wrap flex h-10 items-center rounded-md border border-[#e2e9f2] bg-white px-3 transition focus-within:border-[#347cf0] focus-within:ring-[3px] focus-within:ring-[#347cf0]/[0.11] {{ isset($errors) && $errors->has('access_code') ? 'border-red-300 ring-[3px] ring-red-100' : '' }}">
                            <svg class="mr-2 size-[15px] shrink-0 text-[#70839e]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3.5" y="10" width="17" height="10" rx="2" />
                                <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                                <circle cx="12" cy="15" r="1" />
                            </svg>
                            <input id="access-code" name="access_code" type="password" value="{{ old('access_code') }}" required autocomplete="current-password" placeholder="Masukkan kode akses" class="h-full min-w-0 flex-1 border-0 bg-transparent px-0 text-[12.5px] text-[#334763] outline-none placeholder:text-[#9aa8ba] focus:ring-0" aria-invalid="{{ isset($errors) && $errors->has('access_code') ? 'true' : 'false' }}">
                            <button type="button" data-toggle-access-code aria-label="Tampilkan kode akses" aria-pressed="false" class="ml-2 flex size-8 shrink-0 items-center justify-center rounded-md text-[#70839e] transition hover:bg-[#f1f6fd] hover:text-[#347cf0] focus-visible:outline-2 focus-visible:outline-offset-1 focus-visible:outline-[#347cf0]">
                                <svg viewBox="0 0 24 24" class="size-[17px]" fill="none" aria-hidden="true">
                                    <path d="M2.5 12s3.2-5.5 9.5-5.5 9.5 5.5 9.5 5.5-3.2 5.5-9.5 5.5S2.5 12 2.5 12Z" stroke="currentColor" stroke-width="1.7" />
                                    <circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="doctor-login-submit mt-1 flex min-h-[38px] w-full items-center justify-center rounded-md bg-[#347cf0] text-[12px] font-semibold text-white shadow-sm transition hover:bg-[#286de0] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#347cf0] active:translate-y-px">Masuk</button>
                    @if (isset($errors) && $errors->has('access_code'))
                        <p id="doctor-login-feedback" class="rounded-md bg-red-50 px-3 py-2 text-[12px] leading-relaxed text-red-700" role="alert" aria-live="polite">
                            {{ $errors->first('access_code') }}
                        </p>
                    @else
                        <p id="doctor-login-feedback" class="hidden rounded-md bg-[#f1f6fd] px-3 py-2 text-[12px] leading-relaxed text-[#526b89]" role="status" aria-live="polite"></p>
                    @endif
                </form>

                <button type="button" data-forgot-access-code class="mx-auto mt-3 block text-[11px] font-medium text-[#347cf0] transition hover:text-[#245fb0] focus-visible:rounded focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#347cf0]">Lupa kode akses?</button>

                <div class="doctor-login-privacy mt-5 flex items-start gap-[9px] border-t border-[#edf1f6] pt-3 text-[11.3px] leading-[1.6] text-[#8090a8]">
                    <svg viewBox="0 0 24 24" class="mt-px size-[15px] shrink-0 text-[#70839e]" fill="none" aria-hidden="true">
                        <path d="M12 3.5 19 6v5.3c0 4.5-2.8 7.7-7 9.2-4.2-1.5-7-4.7-7-9.2V6l7-2.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                        <path d="m9.5 11.8 1.7 1.7 3.5-3.8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Halaman ini khusus untuk dokter/admin klinik. Jangan bagikan kode akses Anda.</span>
                </div>
            </div>
        </section>
    </main>
</body>
</html>