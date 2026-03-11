<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') — Usul SHS Bolmut</title>

    <link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    @stack('style')

    <style>
        /* GLOBAL */

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            position: relative;
        }

        /* overlay blur */

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('img/peta.webp') }}') center/cover no-repeat;
            opacity: .15;
            z-index: -1;
        }

        /* auth wrapper */

        .auth-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        /* glass card */

        .auth-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            backdrop-filter: blur(16px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, .4);
            padding: 35px;
        }

        /* header */

        .auth-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
        }

        .auth-logo img {
            height: 48px;
        }

        /* form */

        .form-control {
            height: 48px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, .2);
            background: rgba(255, 255, 255, .08);
            color: white;
        }

        .form-control:focus {
            border-color: #00eaff;
            box-shadow: 0 0 10px rgba(0, 234, 255, .4);
            background: rgba(255, 255, 255, .12);
            color: white;
        }

        label {
            font-size: .85rem;
            color: #ddd;
        }

        /* button */

        .btn-login {
            height: 48px;
            border-radius: 30px;
            background: linear-gradient(135deg, #00c9d8, #00a9b6);
            border: none;
            font-weight: 600;
            letter-spacing: .5px;
            transition: .25s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .3);
        }

        /* footer */

        .auth-footer {
            margin-top: 20px;
            text-align: center;
            font-size: .9rem;
            color: #ddd;
        }

        .auth-footer a {
            color: #00eaff;
            font-weight: 500;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .invalid-feedback {
            color: #ffb3b3;
        }
    </style>

</head>

<body>

    <div class="auth-wrapper">

        @yield('main')

    </div>

    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    @stack('scripts')

</body>

</html>
