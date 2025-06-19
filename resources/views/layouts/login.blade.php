<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>{{ $title ?? 'Archievault' }}</title>
    @livewireStyles

    <style>
        /* Menggunakan font Poppins dari Google Fonts untuk tampilan yang lebih modern */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");

        body {
            font-family: "Poppins", sans-serif;
            /* Warna background utama halaman */
            background-color: #1a2238;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            /* Warna background kartu login */
            background-color: #142141;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 420px;
            width: 100%;
        }

        .login-card .card-body {
            padding: 2.5rem;
        }

        .login-logo {
            font-size: 4rem;
            /* Ukuran ikon logo */
            color: #ffffff;
        }

        .login-title {
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .form-control.custom-input {
            /* Warna background field input */
            background-color: #1a2238;
            border: 1px solid #4a557e;
            color: #ffffff;
            border-radius: 0.5rem;
            padding: 0.85rem 1rem;
        }

        .form-control.custom-input::placeholder {
            color: #a0aec0;
        }

        .form-control.custom-input:focus {
            background-color: #1a2238;
            color: #ffffff;
            border-color: #556ab1;
            box-shadow: none;
        }

        .btn-custom-login {
            /* Warna tombol Sign In */
            background-color: #4a69e2;
            border: none;
            color: #ffffff;
            font-weight: 600;
            padding: 0.85rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
        }

        .btn-custom-login:hover {
            background-color: #3b55b5;
            color: #ffffff;
        }

        .forgot-password-link {
            color: #a0aec0;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password-link:hover {
            color: #ffffff;
        }

        .login-logo-img {
            max-width: 220px;
            height: auto;
        }
    </style>
</head>

<body>
    {{ $slot }}
    @livewireScripts
</body>

</html>
