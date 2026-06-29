@extends('layouts.app')

@section('title', 'Dashboard Admin - BIUperpus')

@section('content')
@php
    $maxPopular = max($popularBooks->max('loans_count') ?? 1, 1);
    $totalLoanStatus = max($loanStatusCounts->sum(), 1);
    $chartBars = [42, 34, 56, 28, 48, 62, 39];
@endphp

<style>
    .biu-admin { display: grid; grid-template-columns: 284px minmax(0, 1fr); min-height: calc(100vh - 124px); background: #eef4f8; color: #172033; }
    .biu-sidebar { background: #062947; padding: 28px 22px; color: #d9e8f5; }
    .biu-logo { display: flex; align-items: center; gap: 12px; margin-bottom: 56px; color: #fff; }
    .biu-logo-mark { width: 42px; height: 42px; border-radius: 8px; display: grid; place-items: center; background: #2495e8; font-weight: 800; }
    .biu-side-nav { display: grid; gap: 8px; }
    .biu-side-nav a { color: #d9e8f5; display: flex; align-items: center; gap: 12px; text-decoration: none; padding: 13px 14px; border-radius: 8px; }
    .biu-side-nav a.active, .biu-side-nav a:hover { background: #2495e8; color: #fff; }
    .side-ico { width: 26px; height: 26px; border: 1px solid currentColor; border-radius: 7px; display: grid; place-items: center; font-size: .72rem; }
    .biu-main { min-width: 0; }
    .biu-content { padding: 28px; }
    .analytics-card { background: #fff; border: 1px solid #dfe8ef; border-radius: 8px; box-shadow: 0 8px 22px rgba(15, 23, 42, .05); }
    .analytics-card .card-body { padding: 22px 24px; }
    .metric-title { color: #8a96a3; font-size: .95rem; margin-bottom: 14px; display: flex; justify-content: space-between; }
    .metric-value { font-size: 1.85rem; font-weight: 600; margin-bottom: 12px; }
    .tiny-wave { height: 70px; position: relative; overflow: hidden; border-bottom: 1px solid #e2e8ef; }
    .tiny-wave::before, .tiny-wave::after { content: ""; position: absolute; left: 0; right: 0; bottom: 12px; height: 42px; clip-path: polygon(0 72%, 10% 38%, 20% 62%, 32% 22%, 43% 54%, 56% 26%, 68% 44%, 80% 16%, 92% 34%, 100% 72%, 100% 100%, 0 100%); }
    .tiny-wave::before { background: rgba(36,149,232,.82); transform: translateY(8px); }
    .tiny-wave::after { background: rgba(61,190,178,.78); }
    .mini-bars { height: 74px; display: flex; align-items: end; gap: 14px; padding: 8px 18px 0; border-bottom: 1px solid #e2e8ef; }
    .mini-bars span { flex: 1; background: #2495e8; min-width: 16px; }
    .operation-card { display: grid; place-items: center; min-height: 100%; text-align: center; }
    .operation-card strong { font-size: 1.8rem; font-weight: 500; }
    .dashboard-panel { background: #fff; border: 1px solid #dfe8ef; border-radius: 8px; box-shadow: 0 8px 22px rgba(15, 23, 42, .05); }
    .panel-tabs { display: flex; gap: 32px; align-items: center; border-bottom: 1px solid #e6edf3; padding: 0 18px; min-height: 64px; color: #6f7b87; }
    .panel-tabs .active { color: #2495e8; border-bottom: 3px solid #2495e8; align-self: stretch; display: flex; align-items: center; }
    .trend-wrap { display: grid; grid-template-columns: minmax(0, 1fr) 290px; gap: 34px; padding: 24px; }
    .bar-chart { height: 270px; display: flex; align-items: end; gap: 22px; padding: 20px 10px 8px; border-left: 1px solid #dfe8ef; border-bottom: 1px solid #dfe8ef; }
    .bar-group { flex: 1; display: flex; align-items: end; justify-content: center; gap: 7px; height: 100%; }
    .bar-group span { width: 24px; border-radius: 3px 3px 0 0; background: #a8cef4; }
    .bar-group span:nth-child(2) { background: #2495e8; }
    .ranking-list { display: grid; gap: 16px; }
    .rank-row { display: grid; grid-template-columns: 30px 1fr auto; gap: 12px; align-items: center; color: #5c6670; }
    .rank-no { width: 24px; height: 24px; border-radius: 999px; display: grid; place-items: center; background: #e9eef3; font-size: .8rem; font-weight: 700; }
    .rank-row:nth-child(-n+3) .rank-no { background: #062947; color: #fff; }
    .status-bar { height: 9px; border-radius: 999px; background: #e9eef3; overflow: hidden; }
    .status-bar span { display: block; height: 100%; background: #2495e8; border-radius: inherit; }
    @media (max-width: 991.98px) {
        .biu-admin { grid-template-columns: 1fr; }
        .biu-sidebar { padding: 22px; }
        .biu-logo { margin-bottom: 24px; }
        .trend-wrap { grid-template-columns: 1fr; }
        .biu-content { padding: 16px; }
    }
</style>

<section class="biu-admin">
    <aside class="biu-sidebar">
        <div class="biu-logo">
            <div class="biu-logo-mark">B</div>
            <div>
                <div class="h4 fw-bold mb-0">BIUperpus</div>
                <div class="small text-white-50">Library Admin</div>
            </div>
        </div>

        <nav class="biu-side-nav">
            <a class="active" href="{{ route('admin.dashboard') }}"><span class="side-ico">DB</span>Dashboard</a>
            <a href="{{ route('books.index') }}"><span class="side-ico">BK</span>Kelola Buku</a>
            <a href="{{ route('books.create') }}"><span class="side-ico">+</span>Tambah Buku</a>
            <a href="{{ route('loans.index') }}"><span class="side-ico">LN</span>Peminjaman</a>
        </nav>
    </aside>

    <div class="biu-main">
        <div class="biu-content">
            <div class="row g-3 mb-4">
                <div class="col-md-6 col-xl-3">
                    <div class="analytics-card h-100">
                        <div class="card-body">
                            <div class="metric-title"><span>Total Koleksi</span><span>i</span></div>
                            <div class="metric-value">{{ $totalBooks }}</div>
                            <div class="small text-muted">Pengguna {{ $totalUsers }} <span class="text-success">naik</span></div>
                            <hr>
                            <div class="text-center">Kategori aktif {{ $popularBooks->count() }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="analytics-card h-100">
                        <div class="card-body">
                            <div class="metric-title"><span>Kunjungan Katalog</span><span>i</span></div>
                            <div class="metric-value">{{ number_format($totalBooks * 324) }}</div>
                            <div class="tiny-wave"></div>
                            <div class="text-center mt-3">Buku aktif {{ $totalBooks }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="analytics-card h-100">
                        <div class="card-body">
                            <div class="metric-title"><span>Payment</span><span>i</span></div>
                            <div class="metric-value">{{ $totalPayments }}</div>
                            <div class="mini-bars"><span style="height:42%"></span><span style="height:82%"></span><span style="height:74%"></span><span style="height:32%"></span><span style="height:58%"></span></div>
                            <div class="text-center mt-3">Total Rp{{ number_format($paymentTotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="analytics-card operation-card">
                        <div>
                            <div class="text-muted mb-3">Operasional</div>
                            <strong>{{ $totalLoanStatus ? round(($returnedLoans / $totalLoanStatus) * 100) : 0 }}%</strong>
                            <div class="small text-muted mt-2">Pengembalian selesai</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-panel mb-4">
                <div class="panel-tabs">
                    <span class="active">Peminjaman</span>
                    <span class="ms-auto">All day</span>
                    <span>All week</span>
                    <span class="text-primary">All year</span>
                </div>
                <div class="trend-wrap">
                    <div>
                        <h2 class="h5 mb-4">Library Activity Trend</h2>
                        <div class="bar-chart">
                            @foreach ($chartBars as $height)
                                <div class="bar-group">
                                    <span style="height: {{ max(22, $height - 12) }}%"></span>
                                    <span style="height: {{ $height }}%"></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <h2 class="h5 mb-4">Book Ranking</h2>
                        <div class="ranking-list">
                            @forelse ($popularBooks as $book)
                                <div class="rank-row">
                                    <span class="rank-no">{{ $loop->iteration }}</span>
                                    <span class="text-truncate">{{ $book->judul }}</span>
                                    <strong>{{ $book->loans_count }}</strong>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Belum ada ranking.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-xl-8">
                    <div class="analytics-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="h5 fw-bold mb-0">Aktivitas Peminjaman</h2>
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('loans.index') }}">Lihat Semua</a>
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
                </div>
                <div class="col-xl-4">
                    <div class="analytics-card h-100">
                        <div class="card-body">
                            <h2 class="h5 fw-bold mb-3">Status Peminjaman</h2>
                            @foreach (['dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan', 'menunggu_konfirmasi' => 'Menunggu'] as $status => $label)
                                @php $count = $loanStatusCounts[$status] ?? 0; @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1"><span>{{ $label }}</span><strong>{{ $count }}</strong></div>
                                    <div class="status-bar"><span style="width: {{ ($count / $totalLoanStatus) * 100 }}%"></span></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
