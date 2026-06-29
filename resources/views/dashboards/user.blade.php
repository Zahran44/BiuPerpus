@extends('layouts.app')

@section('title', 'Dashboard User - BIUperpus')

@section('content')
<section class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Dashboard User</h1>
            <p class="text-muted mb-0">Halo, {{ auth()->user()->username }}. Pinjam buku, cek keranjang, dan lihat riwayatmu di sini.</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-primary" href="{{ route('books.index') }}">Pinjam Buku</a>
            <a class="btn btn-outline-primary" href="{{ route('cart.index') }}">Keranjang ({{ $cartCount }})</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm"><div class="card-body"><span class="text-muted">Dipinjam Aktif</span><h2 class="h3 mb-0">{{ $activeLoans->count() }}</h2></div></div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm"><div class="card-body"><span class="text-muted">Total Riwayat</span><h2 class="h3 mb-0">{{ $loanHistory->count() }}</h2></div></div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm"><div class="card-body"><span class="text-muted">Payment</span><h2 class="h3 mb-0">{{ $payments->count() }}</h2></div></div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm"><div class="card-body"><span class="text-muted">Item Keranjang</span><h2 class="h3 mb-0">{{ $cartCount }}</h2></div></div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 fw-bold mb-0">Buku Sedang Dipinjam</h2>
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('loans.index') }}">Riwayat</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead><tr><th>Buku</th><th>Tanggal Pinjam</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse ($activeLoans as $loan)
                                    <tr>
                                        <td>{{ $loan->book?->judul ?? '-' }}</td>
                                        <td>{{ $loan->tanggal_pinjam?->format('d M Y') }}</td>
                                        <td><span class="badge text-bg-warning">{{ str_replace('_', ' ', $loan->status) }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-muted">Belum ada buku yang sedang dipinjam.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h2 class="h5 fw-bold mb-3">Payment Saya</h2>
                    @forelse ($payments as $payment)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <a class="fw-semibold" href="{{ route('payments.show', $payment) }}">{{ $payment->invoice_number }}</a>
                                <div class="small text-muted">{{ strtoupper($payment->payment_method) }} · {{ $payment->created_at->format('d M Y') }}</div>
                            </div>
                            <strong>Rp{{ number_format($payment->total, 0, ',', '.') }}</strong>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada payment.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 fw-bold mb-0">Rekomendasi Buku</h2>
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('books.index') }}">Lihat Semua</a>
                    </div>
                    <div class="row g-3">
                        @forelse ($recommendedBooks as $book)
                            <div class="col-md-6 col-xl-4">
                                <div class="d-flex gap-3 border rounded p-2 h-100 bg-white">
                                    <img src="{{ $book->coverUrl() }}" alt="{{ $book->judul }}" style="width:64px;height:86px;object-fit:cover;border-radius:6px">
                                    <div class="flex-grow-1">
                                        <h3 class="h6 fw-bold mb-1">{{ $book->judul }}</h3>
                                        <p class="small text-muted mb-2">{{ $book->pengarang }}</p>
                                        <form method="post" action="{{ route('cart.store', $book) }}">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button class="btn btn-primary btn-sm" type="submit">Masuk Keranjang</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12"><p class="text-muted mb-0">Belum ada rekomendasi buku.</p></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="h5 fw-bold mb-3">Riwayat Peminjaman Saya</h2>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead><tr><th>Buku</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse ($loanHistory as $loan)
                                    <tr>
                                        <td>{{ $loan->book?->judul ?? '-' }}</td>
                                        <td>{{ $loan->tanggal_pinjam?->format('d M Y') }}</td>
                                        <td>{{ $loan->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                                        <td><span class="badge text-bg-{{ $loan->status === 'dikembalikan' ? 'success' : 'warning' }}">{{ str_replace('_', ' ', $loan->status) }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-muted">Belum ada riwayat peminjaman.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
