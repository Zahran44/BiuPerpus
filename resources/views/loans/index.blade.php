@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - BIUperpus')

@section('content')
<section class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 fw-bold mb-1">Riwayat Peminjaman</h1>
            <p class="text-muted mb-0">Pantau buku yang sedang dipinjam dan sudah dikembalikan.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('books.index') }}">Pinjam Buku</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loans as $loan)
                            <tr>
                                <td>{{ $loan->book?->judul ?? '-' }}</td>
                                <td>{{ $loan->nama_peminjam }}</td>
                                <td>{{ $loan->tanggal_pinjam?->format('d M Y') }}</td>
                                <td>{{ $loan->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                                <td><span class="badge text-bg-{{ $loan->status === 'dikembalikan' ? 'success' : 'warning' }}">{{ str_replace('_', ' ', $loan->status) }}</span></td>
                                <td class="text-end">
                                    @if ($loan->status !== 'dikembalikan')
                                        <form method="post" action="{{ route('loans.return', $loan) }}">
                                            @csrf
                                            @method('patch')
                                            <button class="btn btn-success btn-sm" type="submit">Kembalikan</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-muted">Belum ada peminjaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $loans->links() }}
        </div>
    </div>
</section>
@endsection
