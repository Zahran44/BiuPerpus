@extends('layouts.app')

@section('title', 'Keranjang - BIUperpus')

@section('content')
<section class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 fw-bold mb-1">Keranjang</h1>
            <p class="text-muted mb-0">Cek buku yang akan dipinjam sebelum payment.</p>
        </div>
        <a class="btn btn-outline-primary" href="{{ route('books.index') }}">Tambah Buku</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Biaya</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $item->book->coverUrl() }}" alt="{{ $item->book->judul }}" style="width:48px;height:64px;object-fit:cover;border-radius:6px">
                                                <div>
                                                    <strong>{{ $item->book->judul }}</strong>
                                                    <div class="small text-muted">Stok tersedia: {{ $item->book->stok }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp{{ number_format($item->book->rental_fee, 0, ',', '.') }}</td>
                                        <td style="width: 150px">
                                            <form method="post" action="{{ route('cart.update', $item) }}" class="d-flex gap-2">
                                                @csrf
                                                @method('patch')
                                                <input class="form-control form-control-sm" type="number" name="quantity" min="1" max="{{ $item->book->stok }}" value="{{ $item->quantity }}">
                                                <button class="btn btn-outline-secondary btn-sm" type="submit">OK</button>
                                            </form>
                                        </td>
                                        <td>Rp{{ number_format($item->subtotal(), 0, ',', '.') }}</td>
                                        <td class="text-end">
                                            <form method="post" action="{{ route('cart.destroy', $item) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-outline-danger btn-sm" type="submit">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-muted">Keranjang masih kosong.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="h5 fw-bold mb-3">Checkout</h2>
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                        <span>Total</span>
                        <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>
                    @if (auth()->user()?->role === 'user')
                        <form method="post" action="{{ route('cart.checkout') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Peminjam/Pembayar</label>
                                <input class="form-control" name="nama_pembayar" value="{{ old('nama_pembayar', auth()->user()->username ?? '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Metode Payment</label>
                                <select class="form-select" name="payment_method" required>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>
                            <button class="btn btn-primary w-100" type="submit" @disabled($items->isEmpty())>Bayar & Pinjam</button>
                        </form>
                    @elseif (! auth()->check())
                        <a class="btn btn-primary w-100" href="{{ route('login') }}">Login untuk Checkout</a>
                    @else
                        <div class="alert alert-light border mb-0">Admin tidak dapat meminjam buku. Silakan gunakan akun user untuk checkout.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
