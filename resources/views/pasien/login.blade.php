<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Masuk Pasien | ClinicOne</title>
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
        input {
            font: inherit;
        }

        a {
            color: #347cf0;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .login-page {
            display: grid;
            grid-template-columns: minmax(340px, 42%) minmax(0, 1fr);
            min-height: 100vh;
        }

        .welcome-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
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

        .login-content {
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

        .login-content h2 {
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

        .registration-status {
            margin: 0 0 14px;
            padding: 10px 12px;
            border: 1px solid #b9e6d2;
            border-radius: 6px;
            color: #18734f;
            background: #effaf4;
            font-size: 12.5px;
            line-height: 1.5;
        }

        .login-error {
            margin: 0 0 14px;
            padding: 10px 12px;
            border: 1px solid #f2c7c7;
            border-radius: 6px;
            color: #a33131;
            background: #fff4f4;
            font-size: 12.5px;
            line-height: 1.5;
        }

        .login-form {
            display: grid;
            gap: 10px;
        }

        .field {
            display: grid;
            gap: 5px;
        }

        .field label {
            color: #334763;
            font-size: 11.3px;
            font-weight: 600;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap input {
            width: 100%;
            height: 35px;
            padding: 0 35px 0 10px;
            border: 1px solid #e2e9f2;
            border-radius: 6px;
            outline: none;
            color: #334763;
            background: #ffffff;
            font-size: 12.5px;
            transition: border-color 150ms ease, box-shadow 150ms ease;
        }

        .input-wrap input::placeholder {
            color: #9aa8ba;
            opacity: 1;
        }

        .input-wrap input:focus {
            border-color: #347cf0;
            box-shadow: 0 0 0 3px #347cf01c;
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

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: -2px;
            font-size: 11.3px;
        }

        .remember-option {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #7c8da7;
        }

        .remember-option input {
            width: 13px;
            height: 13px;
            margin: 0;
            accent-color: #347cf0;
        }

        .submit-button {
            display: inline-flex;
            min-height: 36px;
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

        .signup-prompt {
            margin: 14px 0 0;
            color: #7c8da7;
            font-size: 12.5px;
            text-align: center;
        }

        .signup-prompt a {
            margin-left: 4px;
            font-weight: 600;
        }

        .privacy-note {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-top: 20px;
            padding-top: 12px;
            border-top: 1px solid #edf1f6;
            color: #8090a8;
            font-size: 11.3px;
            line-height: 1.6;
        }

        .privacy-note svg {
            width: 15px;
            height: 15px;
            flex: 0 0 auto;
            margin-top: 1px;
            color: #70839e;
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

            .login-content {
                padding: 4px 0;
            }

            .intro {
                margin-bottom: 10px;
            }

            .login-form {
                gap: 7px;
            }

            .field {
                gap: 3px;
            }

            .input-wrap input {
                height: 28px;
            }

            .submit-button {
                min-height: 30px;
            }

            .signup-prompt {
                margin-top: 9px;
            }

            .privacy-note {
                margin-top: 12px;
                padding-top: 8px;
            }
        }

        @media (max-width: 760px) {
            .login-page {
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

            .login-content {
                padding: 28px 0 24px;
            }

            .legal-links {
                padding-top: 6px;
            }
        }

        @media (max-width: 420px) {
            .welcome-panel {
                padding-top: 20px;
            }

            .doctor-image {
                width: min(62%, 190px);
                max-height: 150px;
            }

            .welcome-copy h1 {
                font-size: 23.8px;
            }

            .login-content {
                padding-top: 24px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/clinicone-interface-scale.css') }}">
</head>
<body>
    <main class="login-page">
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
            <p class="panel-copyright">&copy; 2026 ClinicOne. Kesehatan Anda, prioritas kami.</p>
        </aside>

        <section class="form-panel" aria-labelledby="login-title">
            <div class="login-content">
                <p class="eyebrow">Selamat datang kembali</p>
                <h2 id="login-title">Masuk ke ClinicOne</h2>
                <p class="intro">Akses jadwal pemeriksaan dan riwayat kesehatan Anda dengan mudah.</p>

                @if (session('status'))
                    <p class="registration-status" role="status">{{ session('status') }}</p>
                @endif

                @if ($errors->has('email') || $errors->has('password'))
                    <p class="login-error" role="alert">{{ $errors->first('email') ?: $errors->first('password') }}</p>
                @endif

                <form class="login-form" action="{{ route('pasien.login.submit') }}" method="POST">
                    @csrf
                    <div class="field">
                        <label for="email">Alamat email</label>
                        <div class="input-wrap">
                            <input id="email" name="email" type="email" placeholder="nama@email.com" autocomplete="email" value="{{ old('email') }}" required>
                            <span class="input-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3.5" y="5.5" width="17" height="13" rx="2"/>
                                    <path d="m4.5 7 7.5 6 7.5-6"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="field">
                        <label for="password">Kata sandi</label>
                        <div class="input-wrap">
                            <input id="password" name="password" type="password" placeholder="Masukkan kata sandi" autocomplete="current-password" required>
                            <button class="password-toggle" type="button" aria-label="Tampilkan kata sandi" aria-pressed="false">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M3 3 21 21"/>
                                    <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                                    <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c5.5 0 9 7 9 7a15.8 15.8 0 0 1-3.1 3.8"/>
                                    <path d="M6.2 6.2C3.9 7.7 3 12 3 12s3.5 7 9 7a10 10 0 0 0 3.1-.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="remember-option" for="remember">
                            <input id="remember" name="remember" type="checkbox" value="1" @checked(old('remember'))>
                            <span>Ingat saya</span>
                        </label>
                        <a href="#">Lupa kata sandi?</a>
                    </div>

                    <button class="submit-button" type="submit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        Masuk
                    </button>
                </form>

                <p class="signup-prompt">Belum punya akun?<a href="{{ route('pasien.daftar') }}">Daftar sekarang</a></p>
                <div class="privacy-note">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="4" y="10" width="16" height="11" rx="2"/>
                        <path d="M8 10V7a4 4 0 1 1 8 0v3"/>
                    </svg>
                    <span>Informasi medis Anda hanya dapat diakses oleh Anda dan tenaga kesehatan yang menangani pemeriksaan.</span>
                </div>

            </div>

            <footer class="legal-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat &amp; Ketentuan</a>
            </footer>
        </section>
    </main>

    <script>
        const passwordInput = document.querySelector('#password');
        const passwordToggle = document.querySelector('.password-toggle');

        passwordToggle.addEventListener('click', () => {
            const isPasswordHidden = passwordInput.type === 'password';

            passwordInput.type = isPasswordHidden ? 'text' : 'password';
            passwordToggle.setAttribute('aria-pressed', String(isPasswordHidden));
            passwordToggle.setAttribute('aria-label', isPasswordHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        });
    </script>
</body>
</html>