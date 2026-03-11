@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

    <style>
        /* register card lebih lebar */

        .auth-wrapper {
            max-width: 520px;
        }

        /* password indicator */

        .pwindicator {
            margin-top: 8px;
        }

        .pwindicator .bar {
            height: 4px;
            border-radius: 4px;
            background: #ddd;
        }

        .pwindicator .label {
            font-size: .75rem;
            margin-top: 4px;
            color: #ccc;
        }
    </style>
@endpush


@section('main')

    <div class="auth-card">

        <div class="auth-header">

            <div class="auth-title">
                Register
            </div>

            <div class="auth-logo">
                <img src="{{ asset('img/logo_bpkpd.png') }}">
            </div>

        </div>


        <form method="POST" action="{{ route('register') }}">

            @csrf


            <div class="form-group">

                <label>Nama (sesuai Data Pegawai)</label>

                <input id="frist_name" type="text" class="form-control @error('name') is-invalid @enderror"
                    name="name" placeholder="Masukkan Nama Lengkap" autofocus>

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>



            <div class="form-group">

                <label>Email</label>

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" placeholder="Masukkan email aktif">

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>



            <div class="form-group">

                <label>Nomor Telepon</label>

                <input id="phone" type="text" pattern="[0-9]*" inputmode="numeric" maxlength="15"
                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                    placeholder="Masukkan nomor telepon">

                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>



            <div class="form-group">

                <label>Password</label>

                <input id="password" type="password"
                    class="form-control pwstrength @error('password') is-invalid @enderror" data-indicator="pwindicator"
                    name="password" placeholder="Masukkan Password">

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <div id="pwindicator" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                </div>

            </div>



            <div class="form-group">

                <label>Password Confirmation</label>

                <input id="password2" type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
                    placeholder="Ulangi Password">

                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>



            <div class="form-group mt-4">

                <button type="submit" class="btn btn-login btn-block">

                    Register

                </button>

            </div>


        </form>


        <div class="auth-footer">

            Sudah ada akun?
            <a href="{{ route('login') }}">
                Login disini
            </a>

        </div>

    </div>

@endsection



@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
