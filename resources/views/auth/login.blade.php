@extends('layouts.app')

@section('title', 'Login - BIUperpus')

@section('content')
<style>
    .auth-page { min-height: calc(100vh - 126px); display: grid; place-items: center; padding: 48px 16px; background: radial-gradient(circle at top left, rgba(22,138,91,.18), transparent 32%), linear-gradient(135deg, #062947, #0b3d5f 48%, #168a5b); }
    .auth-shell { width: min(980px, 100%); display: grid; grid-template-columns: 1fr 420px; background: rgba(255,255,255,.96); border-radius: 8px; overflow: hidden; box-shadow: 0 28px 70px rgba(0,0,0,.24); }
    .auth-visual { color: #fff; padding: 48px; background: linear-gradient(rgba(6,41,71,.78), rgba(6,41,71,.78)), url('{{ asset('assets/img/bg-2.png') }}'); background-size: cover; background-position: center; display: flex; flex-direction: column; justify-content: flex-end; min-height: 520px; }
    .auth-visual h1 { font-weight: 900; line-height: 1; }
    .auth-card { padding: 42px; }
    @media (max-width: 860px) { .auth-shell { grid-template-columns: 1fr; } .auth-visual { min-height: 260px; } }
</style>

<section class="auth-page">
    <div class="auth-shell">
        <div class="auth-visual">
            <div>
                <div class="small text-uppercase fw-bold mb-3">BIUperpus Account</div>
                <h1 class="display-6">Masuk dan lanjutkan peminjaman buku.</h1>
                <p class="mb-0 mt-3 text-white-50">Akses dashboard, keranjang, payment, dan riwayat peminjaman dari satu akun.</p>
            </div>
        </div>
        <div class="auth-card">
            <h2 class="h4 fw-bold mb-1">Login</h2>
            <p class="text-muted mb-4">Masuk menggunakan username dan password.</p>
            <form method="post" action="{{ route('login.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Masuk</button>
            </form>
            <div class="d-flex justify-content-between mt-3 small">
                <a href="{{ route('register') }}">Daftar akun</a>
                <a href="{{ route('password.reset') }}">Reset password</a>
            </div>
        </div>
    </div>
</section>
@endsection
