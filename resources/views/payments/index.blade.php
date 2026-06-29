@extends('layouts.app')

@section('title', 'Payment - BIUperpus')

@section('content')
<section class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 fw-bold mb-1">Payment</h1>
            <p class="text-muted mb-0">Daftar transaksi pembayaran peminjaman buku.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('cart.index') }}">Keranjang</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Nama</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment->invoice_number }}</td>
                                <td>{{ $payment->nama_pembayar }}</td>
                                <td>{{ strtoupper($payment->payment_method) }}</td>
                                <td><span class="badge text-bg-{{ $payment->status === 'paid' ? 'success' : 'warning' }}">{{ $payment->status }}</span></td>
                                <td>Rp{{ number_format($payment->total, 0, ',', '.') }}</td>
                                <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                <td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('payments.show', $payment) }}">Detail</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-muted">Belum ada payment.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $payments->links() }}
        </div>
    </div>
</section>
@endsection
