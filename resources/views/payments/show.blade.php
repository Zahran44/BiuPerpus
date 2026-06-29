@extends('layouts.app')

@section('title', 'Invoice '.$payment->invoice_number.' - BIUperpus')

@section('content')
<section class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1 class="h4 fw-bold mb-1">Invoice {{ $payment->invoice_number }}</h1>
                            <p class="text-muted mb-0">{{ $payment->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <span class="badge text-bg-success">{{ $payment->status }}</span>
                    </div>

                    <dl class="row">
                        <dt class="col-sm-4">Nama Pembayar</dt>
                        <dd class="col-sm-8">{{ $payment->nama_pembayar }}</dd>
                        <dt class="col-sm-4">Metode</dt>
                        <dd class="col-sm-8">{{ strtoupper($payment->payment_method) }}</dd>
                        <dt class="col-sm-4">Dibayar Pada</dt>
                        <dd class="col-sm-8">{{ $payment->paid_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </dl>

                    <div class="table-responsive mt-4">
                        <table class="table align-middle">
                            <thead><tr><th>Buku</th><th>Jumlah</th><th>Biaya</th><th>Subtotal</th></tr></thead>
                            <tbody>
                                @foreach ($payment->items as $item)
                                    <tr>
                                        <td>{{ $item->judul_buku }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th>Rp{{ number_format($payment->total, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <a class="btn btn-primary" href="{{ route('payments.index') }}">Semua Payment</a>
                        <a class="btn btn-outline-secondary" href="{{ route('books.index') }}">Daftar Buku</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
