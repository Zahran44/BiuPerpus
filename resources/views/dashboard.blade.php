@extends('layouts.app')

@section('title', 'Dashboard Lama - BIUperpus')

@section('content')
<section class="container py-4">
    <h1 class="h3 fw-bold mb-4">Dashboard</h1>
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3"><div class="card stat-card shadow-sm"><div class="card-body"><span class="text-muted">Total Buku</span><h2 class="h3">{{ $totalBooks }}</h2></div></div></div>
        <div class="col-sm-6 col-lg-3"><div class="card stat-card shadow-sm"><div class="card-body"><span class="text-muted">Pengguna</span><h2 class="h3">{{ $totalUsers }}</h2></div></div></div>
        <div class="col-sm-6 col-lg-3"><div class="card stat-card shadow-sm"><div class="card-body"><span class="text-muted">Dipinjam</span><h2 class="h3">{{ $activeLoans }}</h2></div></div></div>
        <div class="col-sm-6 col-lg-3"><div class="card stat-card shadow-sm"><div class="card-body"><span class="text-muted">Dikembalikan</span><h2 class="h3">{{ $returnedLoans }}</h2></div></div></div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 fw-bold mb-0">Peminjaman Terbaru</h2>
                <a class="btn btn-outline-primary btn-sm" href="{{ route('loans.index') }}">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Buku</th><th>Peminjam</th><th>Tanggal</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($recentLoans as $loan)
                            <tr>
                                <td>{{ $loan->book?->judul ?? '-' }}</td>
                                <td>{{ $loan->nama_peminjam }}</td>
                                <td>{{ $loan->tanggal_pinjam?->format('d M Y') }}</td>
                                <td><span class="badge text-bg-{{ $loan->status === 'dikembalikan' ? 'success' : 'warning' }}">{{ str_replace('_', ' ', $loan->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted">Belum ada peminjaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
