<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Daftar Pasien | ClinicOne</title>
    <style>
        :root {
            color-scheme: light;
            font-family: "Instrument Sans", Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #263b59;
            background: #ffffff;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-width: 320px;
            min-height: 100vh;
            margin: 0;
        }

        button,
        input,
        select {
            font: inherit;
        }

        a {
            color: #347cf0;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .signup-page {
            display: grid;
            grid-template-columns: minmax(340px, 42%) minmax(0, 1fr);
            min-height: 100vh;
        }

        .welcome-panel {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            align-items: center;
            padding: 29px 40px 21px;
            overflow: hidden;
            background: #edf5ff;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            align-self: flex-start;
            color: #263b59;
        }

        .brand-mark {
            display: grid;
            width: 25px;
            height: 25px;
            place-items: center;
            border-radius: 6px;
            color: #ffffff;
            background: #347cf0;
        }

        .brand-mark svg {
            width: 17px;
            height: 17px;
        }

        .brand-name {
            display: block;
            font-size: 18.8px;
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.04em;
        }

        .brand-caption {
            display: block;
            margin-top: 3px;
            color: #8092ad;
            font-size: 11px;
            line-height: 1;
        }

        .welcome-content {
            display: flex;
            width: 100%;
            flex: 1;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 16px 0;
        }

        .doctor-image {
            display: block;
            width: min(100%, 360px);
            max-height: 45vh;
            object-fit: contain;
        }

        .welcome-copy {
            margin-top: 19px;
            text-align: center;
        }

        .welcome-copy h1 {
            margin: 0;
            color: #263b59;
            font-size: clamp(25px, 2vw, 32.5px);
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .welcome-copy p {
            margin: 9px 0 0;
            color: #7c8da7;
            font-size: 16.3px;
        }

        .panel-copyright {
            margin: 0;
            color: #7c8da7;
            font-size: 11.3px;
            text-align: center;
        }

        .form-panel {
            position: relative;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            padding: 22px clamp(30px, 6.5vw, 96px) 20px;
        }

        .help-link {
            align-self: flex-end;
            color: #8090a8;
            font-size: 12.5px;
        }

        .help-link a {
            margin-left: 4px;
        }

        .signup-content {
            width: min(100%, 540px);
            margin: auto 0;
            padding: 10px 0;
        }

        .eyebrow {
            margin: 0 0 6px;
            color: #347cf0;
            font-size: 11.3px;
            font-weight: 700;
            letter-spacing: 0.035em;
            text-transform: uppercase;
        }

        .signup-content h2 {
            margin: 0;
            color: #263b59;
            font-size: clamp(30px, 2.3vw, 37.5px);
            font-weight: 700;
            letter-spacing: -0.045em;
            line-height: 1.2;
        }

        .intro {
            margin: 7px 0 17px;
            color: #7c8da7;
            font-size: 13.8px;
            line-height: 1.5;
        }

        .signup-form {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px 10px;
        }

        .field {
            display: grid;
            min-width: 0;
            align-content: start;
            gap: 5px;
        }

        .field--full {
            grid-column: 1 / -1;
        }

        .field label {
            color: #334763;
            font-size: 11.3px;
            font-weight: 600;
        }

        .input-wrap {
            position: relative;
        }

        .field input,
        .field select {
            width: 100%;
            height: 35px;
            padding: 0 10px;
            border: 1px solid #e2e9f2;
            border-radius: 6px;
            outline: none;
            color: #334763;
            background: #ffffff;
            font-size: 12.5px;
            transition: border-color 150ms ease, box-shadow 150ms ease;
        }

        .field input::placeholder {
            color: #9aa8ba;
            opacity: 1;
        }

        .field input:focus,
        .field select:focus {
            border-color: #347cf0;
            box-shadow: 0 0 0 3px #347cf01c;
        }

        .field input[type="date"] {
            color-scheme: light;
        }

        .input-wrap input {
            padding-right: 35px;
        }

        .input-icon,
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 9px;
            display: grid;
            width: 17px;
            height: 17px;
            padding: 0;
            place-items: center;
            transform: translateY(-50%);
            border: 0;
            color: #70839e;
            background: transparent;
        }

        .input-icon svg,
        .password-toggle svg {
            width: 14px;
            height: 14px;
        }

        .password-toggle {
            cursor: pointer;
        }

        .field-error {
            margin: 0;
            color: #d14343;
            font-size: 11.3px;
        }

        .password-hint {
            display: flex;
            grid-column: 1 / -1;
            align-items: center;
            gap: 5px;
            margin-top: -4px;
            color: #2eaa83;
            font-size: 11.3px;
        }

        .password-hint svg {
            width: 12px;
            height: 12px;
            flex: 0 0 auto;
        }

        .terms-option {
            display: flex;
            grid-column: 1 / -1;
            align-items: flex-start;
            gap: 7px;
            color: #7c8da7;
            font-size: 11.3px;
            line-height: 1.5;
        }

        .terms-option input {
            width: 13px;
            height: 13px;
            flex: 0 0 auto;
            margin: 0;
            accent-color: #347cf0;
        }

        .terms-option a {
            color: #7c8da7;
        }

        .submit-button {
            display: inline-flex;
            min-height: 36px;
            grid-column: 1 / -1;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: -1px;
            border: 0;
            border-radius: 6px;
            color: #ffffff;
            background: #347cf0;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: background 150ms ease, transform 150ms ease;
        }

        .submit-button:hover {
            background: #286de0;
        }

        .submit-button:active {
            transform: translateY(1px);
        }

        .submit-button svg {
            width: 14px;
            height: 14px;
        }

        .signin-prompt {
            margin: 14px 0 0;
            color: #7c8da7;
            font-size: 12.5px;
            text-align: center;
        }

        .signin-prompt a {
            margin-left: 4px;
            font-weight: 600;
        }

        .legal-links {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            color: #8090a8;
            font-size: 11.3px;
        }

        .legal-links a {
            color: inherit;
        }

        @media (min-width: 761px) and (max-height: 650px) {
            .form-panel {
                padding-top: 12px;
                padding-bottom: 12px;
            }

            .signup-content {
                padding: 4px 0;
            }

            .intro {
                margin-bottom: 10px;
            }

            .signup-form {
                gap: 7px 9px;
            }

            .field {
                gap: 3px;
            }

            .field input,
            .field select {
                height: 28px;
            }

            .password-hint {
                margin-top: -2px;
            }

            .submit-button {
                min-height: 30px;
            }

            .signin-prompt {
                margin-top: 9px;
            }
        }

        @media (max-width: 760px) {
            .signup-page {
                grid-template-columns: 1fr;
            }

            .welcome-panel {
                min-height: auto;
                padding: 20px clamp(22px, 6vw, 40px) 18px;
            }

            .welcome-content {
                padding: 13px 0 4px;
            }

            .doctor-image {
                width: min(65%, 230px);
                max-height: 185px;
            }

            .welcome-copy {
                margin-top: 9px;
            }

            .welcome-copy h1 {
                font-size: 25px;
            }

            .welcome-copy p {
                margin-top: 5px;
                font-size: 13.8px;
            }

            .panel-copyright {
                display: none;
            }

            .form-panel {
                min-height: auto;
                padding: 18px clamp(22px, 6vw, 40px) 20px;
            }

            .help-link {
                position: absolute;
                top: 23px;
                right: clamp(22px, 6vw, 40px);
            }

            .signup-content {
                padding: 28px 0 24px;
            }

            .legal-links {
                padding-top: 6px;
            }
        }

        @media (max-width: 420px) {
            .signup-form {
                grid-template-columns: 1fr;
            }

            .field--full,
            .password-hint,
            .terms-option,
            .submit-button {
                grid-column: auto;
            }

            .doctor-image {
                width: min(62%, 190px);
                max-height: 150px;
            }

            .signup-content {
                padding-top: 24px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/clinicone-interface-scale.css') }}">
</head>
<body>
    <main class="signup-page">
        <aside class="welcome-panel" aria-label="Selamat datang di ClinicOne">
            <a class="brand" href="{{ url('/') }}" aria-label="ClinicOne, halaman utama">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M9 4h6v5h5v6h-5v5H9v-5H4V9h5V4Z" fill="currentColor"/>
                    </svg>
                </span>
                <span>
                    <span class="brand-name">ClinicOne</span>
                    <span class="brand-caption">Klinik Umum</span>
                </span>
            </a>

            <div class="welcome-content">
                <img class="doctor-image" src="{{ asset('img/Doctor.png') }}" alt="Ilustrasi dokter menyambut pasien">
                <div class="welcome-copy">
                    <h1>Selamat Datang di ClinicOne</h1>
                    <p>Kelola janji dan jadwal pasien dengan mudah.</p>
                </div>
            </div>

        </aside>

        <section class="form-panel" aria-labelledby="signup-title">
            <div class="signup-content">
                <p class="eyebrow">Mulai langkah sehat Anda</p>
                <h2 id="signup-title">Buat akun pasien</h2>
                <p class="intro">Lengkapi data diri untuk menggunakan layanan ClinicOne.</p>

                <form class="signup-form" action="#" method="POST">
                    @csrf
                    <div class="field field--full">
                        <label for="name">Nama lengkap *</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Nama lengkap sesuai identitas" autocomplete="name" required>
                        @error('name')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="birth_date">Tanggal lahir *</label>
                        <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date') }}" autocomplete="bday" required>
                        @error('birth_date')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="gender">Jenis kelamin *</label>
                        <select id="gender" name="gender" required>
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih jenis kelamin</option>
                            <option value="perempuan" {{ old('gender') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            <option value="laki-laki" {{ old('gender') === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        </select>
                        @error('gender')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="phone">Nomor ponsel *</label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="0812 3456 7890" autocomplete="tel" required>
                        @error('phone')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="nik">NIK *</label>
                        <input id="nik" name="nik" type="text" value="{{ old('nik') }}" placeholder="16 digit NIK" inputmode="numeric" autocomplete="off" minlength="16" maxlength="16" pattern="[0-9]{16}" required>
                        @error('nik')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field field--full">
                        <label for="email">Alamat email *</label>
                        <div class="input-wrap">
                            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email" required>
                            <span class="input-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3.5" y="5.5" width="17" height="13" rx="2"/>
                                    <path d="m4.5 7 7.5 6 7.5-6"/>
                                </svg>
                            </span>
                        </div>
                        @error('email')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Kata sandi *</label>
                        <div class="input-wrap">
                            <input id="password" name="password" type="password" placeholder="Buat kata sandi" autocomplete="new-password" minlength="8" required>
                            <button class="password-toggle" type="button" aria-label="Tampilkan kata sandi" aria-pressed="false">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M3 3 21 21"/>
                                    <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                                    <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c5.5 0 9 7 9 7a15.8 15.8 0 0 1-3.1 3.8"/>
                                    <path d="M6.2 6.2C3.9 7.7 3 12 3 12s3.5 7 9 7a10 10 0 0 0 3.1-.5"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Konfirmasi kata sandi *</label>
                        <div class="input-wrap">
                            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi kata sandi" autocomplete="new-password" minlength="8" required>
                            <button class="password-toggle" type="button" aria-label="Tampilkan konfirmasi kata sandi" aria-pressed="false">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M3 3 21 21"/>
                                    <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                                    <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c5.5 0 9 7 9 7a15.8 15.8 0 0 1-3.1 3.8"/>
                                    <path d="M6.2 6.2C3.9 7.7 3 12 3 12s3.5 7 9 7a10 10 0 0 0 3.1-.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <p class="password-hint">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="m8.5 12 2.3 2.3 4.8-5"/>
                        </svg>
                        Kata sandi kuat &bull; Minimal 8 karakter, huruf dan angka
                    </p>

                    <label class="terms-option" for="terms">
                        <input id="terms" name="terms" type="checkbox" value="1" required>
                        <span>Saya menyetujui <a href="#">Syarat &amp; Ketentuan</a> serta <a href="#">Kebijakan Privasi</a> ClinicOne untuk pengelolaan data pasien.</span>
                    </label>

                    <button class="submit-button" type="submit">
                        Daftar akun
                    </button>
                </form>

                <p class="signin-prompt">Sudah punya akun?<a href="{{ url('/pasien/login') }}">Masuk di sini</a></p>
            </div>

        </section>
    </main>

    <script>
        document.querySelectorAll('.password-toggle').forEach((toggle) => {
            toggle.addEventListener('click', () => {
                const passwordInput = toggle.parentElement.querySelector('input');
                const isPasswordHidden = passwordInput.type === 'password';

                passwordInput.type = isPasswordHidden ? 'text' : 'password';
                toggle.setAttribute('aria-pressed', String(isPasswordHidden));
                toggle.setAttribute('aria-label', isPasswordHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
            });
        });
    </script>
</body>
</html>