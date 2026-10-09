<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#eef6ff">
    <title>Login Dokter | ClinicOne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 min-h-screen font-sans text-slate-800 antialiased">
    <main class="grid min-h-screen grid-cols-1 lg:grid-cols-[47%_53%]">
        <section class="flex min-h-[610px] flex-col bg-[#eef6ff] px-6 py-8 sm:px-10 lg:min-h-screen lg:px-[9%] lg:py-10">
            <a href="{{ route('home') }}" class="flex w-fit items-center gap-2.5 no-underline" aria-label="ClinicOne, halaman utama">
                <span class="flex size-8 items-center justify-center rounded-[7px] bg-[#347fe0] text-white shadow-sm">
                    <svg viewBox="0 0 24 24" class="size-5" fill="none" aria-hidden="true">
                        <path d="M10 4h4v6h6v4h-6v6h-4v-6H4v-4h6V4Z" fill="currentColor" />
                    </svg>
                </span>
                <span class="flex flex-col leading-tight">
                    <span class="text-[16px] font-bold tracking-normal text-[#203752]">ClinicOne</span>
                    <span class="mt-0.5 text-[9px] font-medium text-[#8194ad]">Klinik Umum</span>
                </span>
            </a>

            <div class="mx-auto flex w-full max-w-[440px] grow flex-col items-center justify-center gap-5 py-10 text-center lg:py-0">
                <svg viewBox="0 0 440 320" class="w-full max-w-[390px]" role="img" aria-label="Ilustrasi dokter dan kalender janji pasien">
                    <circle cx="218" cy="143" r="122" fill="#d8e9ff" />
                    <circle cx="45" cy="59" r="4" fill="#a9c9f4" />
                    <circle cx="384" cy="226" r="5" fill="#a9c9f4" />
                    <ellipse cx="221" cy="294" rx="174" ry="8" fill="#c5ddfb" />

                    <rect x="50" y="104" width="175" height="185" rx="16" fill="#fff" />
                    <path d="M50 120a16 16 0 0 1 16-16h143a16 16 0 0 1 16 16v26H50v-26Z" fill="#347fe0" />
                    <rect x="82" y="94" width="8" height="25" rx="4" fill="#285b96" />
                    <rect x="186" y="94" width="8" height="25" rx="4" fill="#285b96" />
                    <rect x="70" y="125" width="61" height="5" rx="2.5" fill="#d8e9ff" />
                    <rect x="70" y="135" width="43" height="3" rx="1.5" fill="#a9c9f4" />
                    <g fill="#e9f2ff">
                        <rect x="68" y="164" width="25" height="23" rx="6" />
                        <rect x="106" y="164" width="25" height="23" rx="6" />
                        <rect x="144" y="164" width="25" height="23" rx="6" />
                        <rect x="182" y="164" width="25" height="23" rx="6" />
                        <rect x="68" y="198" width="25" height="23" rx="6" />
                        <rect x="106" y="198" width="25" height="23" rx="6" />
                        <rect x="144" y="198" width="25" height="23" rx="6" />
                        <rect x="182" y="198" width="25" height="23" rx="6" />
                        <rect x="68" y="232" width="25" height="23" rx="6" />
                        <rect x="144" y="232" width="25" height="23" rx="6" />
                        <rect x="182" y="232" width="25" height="23" rx="6" />
                    </g>
                    <rect x="106" y="232" width="25" height="23" rx="6" fill="#347fe0" />
                    <path d="m112 243 4 4 9-10" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />

                    <rect x="312" y="71" width="73" height="55" rx="15" fill="#fff" />
                    <circle cx="347" cy="98" r="18" fill="#eaf3ff" />
                    <path d="m339 98 5 5 10-11" stroke="#347fe0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />

                    <path d="M267 187c-20 0-32 11-38 29l-13 40 27 10 10-29 1 52h76l-2-53 11 30 25-12-17-42c-7-17-19-25-40-25h-40Z" fill="#fff" />
                    <path d="m259 208-13 49 12 5 12-41m67-13 16 44-12 6-14-39" fill="#d9eaff" />
                    <path d="m278 197 18 14 19-14-5-15h-28l-4 15Z" fill="#f3c7a9" />
                    <path d="m280 205 16 12 20-12 10 10-12 35 4 67h-44l5-67-11-35 12-10Z" fill="#d7eaff" />
                    <path d="m287 217 9 9 10-9-5-8h-9l-5 8Z" fill="#fff" />
                    <path d="m285 250-3 47-8 23h21l6-70m10 0 5 47 8 23h-21l-5-70" fill="#294d76" />
                    <path d="M273 317h23v7h-28c0-4 2-7 5-7Zm36 0h20c4 0 6 3 6 7h-27l1-7Z" fill="#203752" />
                    <path d="M278 135c0-17 8-28 20-28s21 11 21 28v26c0 14-9 24-21 24s-20-10-20-24v-26Z" fill="#f3c7a9" />
                    <path d="M276 140c-5-23 4-39 21-41 16-2 26 9 25 29-7 0-14-2-20-7-7 7-15 11-26 10v9Z" fill="#29415b" />
                    <path d="M278 147c-7-3-10 1-8 8 2 5 6 8 10 7m39-15c7-3 10 1 8 8-2 5-6 8-10 7" fill="#f3c7a9" />
                    <circle cx="289" cy="149" r="1.5" fill="#29415b" />
                    <circle cx="308" cy="149" r="1.5" fill="#29415b" />
                    <path d="M291 161c4 3 9 3 13 0" stroke="#bd806e" stroke-width="1.8" stroke-linecap="round" />
                    <path d="M267 201c-4 11-2 26 7 34m57-34c7 11 9 22 7 33" fill="none" stroke="#90afd3" stroke-width="2.5" stroke-linecap="round" />
                </svg>

                <div class="flex flex-col gap-2">
                    <h1 class="text-[22px] font-bold leading-tight text-[#263c57] sm:text-[25px]">Selamat Datang di ClinicOne</h1>
                    <p class="text-[13px] text-[#8395ad]">Kelola janji dan jadwal pasien dengan mudah.</p>
                </div>
            </div>
        </section>

        <section class="flex min-h-[570px] items-center justify-center bg-[#f5f8fd] px-5 py-12 sm:px-8 lg:min-h-screen lg:px-10">
            <div class="doctor-login-enter w-full max-w-[380px] rounded-[12px] border border-[#e8eef6] bg-white px-6 py-7 shadow-[0_12px_34px_rgba(54,87,129,0.08)] sm:px-8 sm:py-8">
                <div class="mb-5 flex size-9 items-center justify-center rounded-[9px] bg-[#eaf3ff] text-[#4388ed]">
                    <svg viewBox="0 0 24 24" class="size-[19px]" fill="none" aria-hidden="true">
                        <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.8" />
                        <path d="M8 10V7a4 4 0 0 1 8 0v3m-4 4v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        <circle cx="12" cy="14" r="1" fill="currentColor" />
                    </svg>
                </div>

                <h2 class="text-[21px] font-bold leading-tight text-[#263c57]">Login Dokter</h2>
                <p class="mt-2 text-[12px] text-[#8796aa]">Masuk untuk mengelola layanan klinik.</p>

                <form method="POST" action="{{ route('dokter.login.submit') }}" class="mt-6" data-doctor-login-form novalidate>
                    @csrf
                    <label for="access-code" class="mb-2 block text-[11px] font-semibold text-[#51647d]">Kode Akses</label>
                    <div class="flex h-[43px] items-center rounded-[7px] border border-[#dce5f0] bg-white px-3 transition focus-within:border-[#4388ed] focus-within:ring-2 focus-within:ring-[#4388ed]/15 {{ isset($errors) && $errors->has('access_code') ? 'border-red-300 ring-2 ring-red-100' : '' }}">
                        <input id="access-code" name="access_code" type="password" value="{{ old('access_code') }}" required autocomplete="current-password" placeholder="Masukkan kode akses" class="h-full min-w-0 flex-1 border-0 bg-transparent text-[12px] text-[#334a66] outline-none placeholder:text-[#a0adbd] focus:ring-0" aria-invalid="{{ isset($errors) && $errors->has('access_code') ? 'true' : 'false' }}">
                        <button type="button" data-toggle-access-code aria-label="Tampilkan kode akses" aria-pressed="false" class="ml-2 flex size-8 shrink-0 items-center justify-center rounded-md text-[#8294ad] transition hover:bg-[#f1f6fd] hover:text-[#347fe0] focus-visible:outline-2 focus-visible:outline-offset-1 focus-visible:outline-[#347fe0]">
                            <svg viewBox="0 0 24 24" class="size-[17px]" fill="none" aria-hidden="true">
                                <path d="M2.5 12s3.2-5.5 9.5-5.5 9.5 5.5 9.5 5.5-3.2 5.5-9.5 5.5S2.5 12 2.5 12Z" stroke="currentColor" stroke-width="1.7" />
                                <circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.7" />
                            </svg>
                        </button>
                    </div>

                    <button type="submit" class="mt-4 flex h-[43px] w-full items-center justify-center rounded-[7px] bg-[#347fe0] text-[12px] font-semibold text-white shadow-sm transition hover:bg-[#286fc9] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#347fe0] active:translate-y-px">Masuk</button>
                    @if (isset($errors) && $errors->has('access_code'))
                        <p id="doctor-login-feedback" class="mt-3 rounded-md bg-red-50 px-3 py-2 text-[11px] leading-relaxed text-red-700" role="alert" aria-live="polite">
                            {{ $errors->first('access_code') }}
                        </p>
                    @else
                        <p id="doctor-login-feedback" class="mt-3 hidden rounded-md bg-[#f1f6fd] px-3 py-2 text-[11px] leading-relaxed text-[#526b89]" role="status" aria-live="polite"></p>
                    @endif
                </form>

                <button type="button" data-forgot-access-code class="mx-auto mt-3 block text-[11px] font-medium text-[#347fe0] transition hover:text-[#245fb0] focus-visible:rounded focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#347fe0]">Lupa kode akses?</button>

                <div class="mt-5 flex items-center gap-2 border-t border-[#edf1f6] pt-4 text-center text-[10px] text-[#8796aa]">
                    <svg viewBox="0 0 24 24" class="mx-auto size-[14px] shrink-0 text-[#8294ad]" fill="none" aria-hidden="true">
                        <path d="M12 3.5 19 6v5.3c0 4.5-2.8 7.7-7 9.2-4.2-1.5-7-4.7-7-9.2V6l7-2.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                        <path d="m9.5 11.8 1.7 1.7 3.5-3.8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="flex-1">Halaman ini khusus untuk dokter/admin klinik.</span>
                </div>
            </div>
        </section>
    </main>
</body>
</html>