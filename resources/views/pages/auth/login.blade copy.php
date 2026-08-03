@extends('layouts.auth')

@section('title', 'Login')

@section('main')

    <div class="auth-card">

        <div class="auth-header">

            <div class="auth-title">
                Login
            </div>

            <div class="auth-logo">
                <img src="{{ asset('img/logo_bpkpd.png') }}">
            </div>

        </div>


        <form method="POST" action="{{ route('login') }}">

            @csrf

            <div class="form-group">

                <label>Email</label>

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    autofocus placeholder="Masukkan email">

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label>Password</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="Masukkan password">

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group mt-4">

                <button type="submit" class="btn btn-login btn-block">

                    Login

                </button>

            </div>

        </form>

        <div class="auth-footer">

            Blum ada akun?
            <a href="{{ route('register') }}">
                Bekeng Akun disini
            </a>

        </div>

    </div>

@endsection
