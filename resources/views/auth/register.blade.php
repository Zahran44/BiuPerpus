@extends('layouts.app')

@section('title', 'Register - BIUperpus')

@section('content')
<style>
    .auth-page { min-height: calc(100vh - 126px); display: grid; place-items: center; padding: 48px 16px; background: radial-gradient(circle at top right, rgba(36,149,232,.22), transparent 32%), linear-gradient(135deg, #062947, #0b3d5f 48%, #168a5b); }
    .auth-shell { width: min(980px, 100%); display: grid; grid-template-columns: 1fr 420px; background: rgba(255,255,255,.96); border-radius: 8px; overflow: hidden; box-shadow: 0 28px 70px rgba(0,0,0,.24); }
    .auth-visual { color: #fff; padding: 48px; background: linear-gradient(rgba(6,41,71,.76), rgba(6,41,71,.76)), url('{{ asset('assets/img/bg-1.jpg') }}'); background-size: cover; background-position: center; display: flex; flex-direction: column; justify-content: flex-end; min-height: 560px; }
    .auth-visual h1 { font-weight: 900; line-height: 1; }
    .auth-card { padding: 42px; }
    @media (max-width: 860px) { .auth-shell { grid-template-columns: 1fr; } .auth-visual { min-height: 260px; } }
</style>

<section class="auth-page">
    <div class="auth-shell">
        <div class="auth-visual">
            <div>
                <div class="small text-uppercase fw-bold mb-3">Join BIUperpus</div>
                <h1 class="display-6">Buat akun untuk mulai meminjam buku.</h1>
                <p class="mb-0 mt-3 text-white-50">Akun user dapat memakai keranjang, checkout, dan melihat riwayat peminjaman pribadi.</p>
            </div>
        </div>
        <div class="auth-card">
            <h2 class="h4 fw-bold mb-1">Register</h2>
            <p class="text-muted mb-4">Daftar akun baru untuk mulai meminjam buku.</p>
            <form method="post" action="{{ route('register.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input class="form-control" name="username" value="{{ old('username') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input class="form-control" type="password" name="password_confirmation" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Buat Akun</button>
            </form>
            <p class="small mt-3 mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </div>
</section>
@endsection
