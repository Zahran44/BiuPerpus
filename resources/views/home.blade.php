@extends('layouts.app')

@section('title', 'BIUperpus')
@section('hide_header', true)

@section('content')
<style>
    .ebook-page { min-height: 100vh; background: #fff; padding: 0; }
    .ebook-frame { width: 100%; min-height: 100vh; margin: 0; background: #fff; box-shadow: none; }
    .ebook-hero {
        min-height: 100vh;
        color: #fff;
        position: relative;
        background:
            linear-gradient(90deg, rgba(7, 26, 45, .76), rgba(7, 26, 45, .18)),
            linear-gradient(rgba(7, 26, 45, .14), rgba(7, 26, 45, .14)),
            url('{{ asset('assets/img/landing-ebook-bg.png') }}');
        background-size: cover;
        background-position: center;
    }
    .ebook-header { height: 72px; background: rgba(10, 24, 34, .64); border-bottom: 1px solid rgba(255,255,255,.12); display: flex; align-items: center; justify-content: space-between; padding: 0 clamp(24px, 7vw, 112px); }
    .ebook-brand { display: inline-flex; align-items: center; gap: 10px; color: #fff; text-decoration: none; font-weight: 800; letter-spacing: .03em; }
    .ebook-brand img { width: 38px; height: 34px; object-fit: contain; filter: drop-shadow(0 2px 8px rgba(0,0,0,.28)); }
    .ebook-menu { display: flex; align-items: center; gap: 28px; font-size: .72rem; font-weight: 800; letter-spacing: .03em; }
    .ebook-menu form { margin: 0; }
    .ebook-menu a, .ebook-menu button { color: rgba(255,255,255,.86); text-decoration: none; height: 60px; display: flex; align-items: center; border: 0; border-bottom: 3px solid transparent; background: transparent; padding: 0; font: inherit; }
    .ebook-menu a.active, .ebook-menu a:hover, .ebook-menu button:hover { color: #fff; border-color: #168a5b; }
    .ebook-copy { max-width: 580px; padding: clamp(130px, 20vh, 210px) 0 0 clamp(24px, 10vw, 150px); text-shadow: 0 3px 20px rgba(0,0,0,.28); }
    .ebook-copy h1 { font-size: clamp(2.5rem, 5vw, 4.25rem); line-height: .98; font-weight: 900; letter-spacing: .02em; margin-bottom: 22px; }
    .ebook-copy p { max-width: 460px; color: rgba(255,255,255,.88); font-size: .95rem; }
    .ebook-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 28px; }
    .ebook-actions .btn { min-width: 132px; font-weight: 800; }
    .feature-section { padding: 72px 90px; text-align: center; }
    .feature-section h2 { font-weight: 900; letter-spacing: .04em; }
    .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 46px; }
    .feature-card { min-height: 188px; border: 1px solid #edf1f4; display: grid; place-items: center; padding: 28px; box-shadow: 0 12px 28px rgba(15,23,42,.06); }
    .feature-card .feature-icon { width: 42px; height: 42px; border-radius: 10px; background: #e7f6ef; color: #168a5b; display: grid; place-items: center; font-weight: 900; margin: 0 auto 18px; }
    .favorite-strip { padding: 0 90px 72px; }
    .landing-card { border: 0; border-radius: 8px; box-shadow: 0 12px 30px rgba(15, 23, 42, .08); overflow: hidden; text-align: left; }
    @media (max-width: 991.98px) {
        .ebook-page { padding: 0; }
        .ebook-header { height: auto; padding: 16px 22px; align-items: flex-start; gap: 16px; flex-direction: column; }
        .ebook-menu { flex-wrap: wrap; gap: 12px 18px; }
        .ebook-menu a, .ebook-menu button { height: auto; padding-bottom: 6px; }
        .ebook-copy { padding: 90px 24px 60px; }
        .feature-section, .favorite-strip { padding-left: 24px; padding-right: 24px; }
        .feature-grid { grid-template-columns: 1fr; }
    }
</style>

<section class="ebook-page">
    <div class="ebook-frame">
        <div class="ebook-hero">
            <header class="ebook-header">
                <a class="ebook-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/logo2.png') }}" alt="Logo kampus">
                    <span>BIUperpus</span>
                </a>
                <nav class="ebook-menu">
                    <a class="active" href="{{ route('home') }}">HOME</a>
                    <a href="#features">FEATURE</a>
                    <a href="{{ route('books.index') }}">BOOKS</a>
                    <a href="{{ route('dashboard') }}">DASHBOARD</a>
                    @auth
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">LOGOUT</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">LOGIN</a>
                    @endauth
                </nav>
            </header>
            <div class="ebook-copy">
                <h1>BIUPERPUS<br>DIGITAL LIBRARY</h1>
                <p>Temukan koleksi BIUperpus, pinjam buku pilihan, masukkan ke keranjang, dan pantau transaksi dalam satu pengalaman digital yang rapi.</p>
                <div class="ebook-actions">
                    <a class="btn btn-primary" href="{{ route('books.index') }}">PINJAM BUKU</a>
                    <a class="btn btn-light" href="{{ route('register') }}">DAFTAR</a>
                </div>
            </div>
        </div>

        <section id="features" class="feature-section">
            <h2>FEATURES</h2>
            <p class="text-muted">Layanan utama BIUperpus untuk peminjaman buku modern.</p>
            <div class="feature-grid">
                <div class="feature-card"><div><div class="feature-icon">01</div><h3 class="h6 fw-bold">Katalog Cepat</h3><p class="small text-muted mb-0">Cari buku berdasarkan judul, pengarang, dan kategori koleksi.</p></div></div>
                <div class="feature-card"><div><div class="feature-icon">02</div><h3 class="h6 fw-bold">Keranjang Buku</h3><p class="small text-muted mb-0">Kumpulkan buku yang ingin dipinjam sebelum checkout.</p></div></div>
                <div class="feature-card"><div><div class="feature-icon">03</div><h3 class="h6 fw-bold">Payment & Riwayat</h3><p class="small text-muted mb-0">Pantau invoice, status peminjaman, dan pengembalian.</p></div></div>
            </div>
        </section>

        <section class="favorite-strip">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 fw-bold mb-0">Buku Favorit</h2>
                <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-sm">Semua Buku</a>
            </div>
            <div class="row g-4">
                @forelse ($favoriteBooks as $book)
                    <div class="col-sm-6 col-lg-3">
                        <div class="card landing-card h-100">
                            <img src="{{ $book->coverUrl() }}" class="card-img-top book-cover" alt="{{ $book->judul }}">
                            <div class="card-body">
                                <h3 class="h6 fw-bold">{{ $book->judul }}</h3>
                                <p class="small text-muted mb-2">{{ $book->pengarang }}</p>
                                <span class="badge text-bg-primary">{{ $book->total_pinjam }} kali kembali</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><div class="alert alert-info">Belum ada data buku favorit.</div></div>
                @endforelse
            </div>
        </section>
    </div>
</section>
@endsection
