@extends('layouts.app')

@section('title', 'Daftar Buku - BIUperpus')

@section('content')
<section class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h1 class="h3 fw-bold mb-1">Daftar Buku</h1>
            <p class="text-muted mb-0">Koleksi buku dari project PHP lama yang sudah berjalan di Laravel.</p>
        </div>
        @if (auth()->user()?->role === 'admin')
            <a href="{{ route('books.create') }}" class="btn btn-primary">Tambah Buku</a>
        @endif
    </div>

    <form class="mb-4" method="get" action="{{ route('books.index') }}">
        <div class="input-group">
            <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari judul, pengarang, atau genre">
            <button class="btn btn-outline-primary" type="submit">Cari</button>
        </div>
    </form>

    <div class="row g-4">
        @forelse ($books as $book)
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="{{ $book->coverUrl() }}" class="book-cover rounded-start h-100" alt="{{ $book->judul }}">
                        </div>
                        <div class="col-8">
                            <div class="card-body d-flex flex-column h-100">
                                <h2 class="h6 fw-bold">{{ $book->judul }}</h2>
                                <p class="small text-muted mb-1">{{ $book->pengarang }} &middot; {{ $book->tahun_terbit }}</p>
                                <p class="small mb-1">Stok: <strong>{{ $book->stok }}</strong></p>
                                <p class="small mb-2">Biaya: <strong>Rp{{ number_format($book->rental_fee, 0, ',', '.') }}</strong></p>
                                <div class="mb-2">
                                    @foreach ($book->genres as $genre)
                                        <span class="badge text-bg-light border">{{ $genre->nama_genre }}</span>
                                    @endforeach
                                </div>
                                @if (auth()->user()?->role === 'user')
                                    <form method="post" action="{{ route('books.borrow', $book) }}" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">
                                        <div class="input-group input-group-sm mb-2">
                                            <input class="form-control" name="nama_peminjam" value="{{ auth()->user()->username }}" placeholder="Nama peminjam" required>
                                            <button class="btn btn-success" type="submit" @disabled($book->stok < 1)>Pinjam</button>
                                        </div>
                                    </form>
                                    <form method="post" action="{{ route('cart.store', $book) }}" class="mb-2">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <input class="form-control" type="number" min="1" max="{{ max($book->stok, 1) }}" name="quantity" value="1">
                                            <button class="btn btn-primary" type="submit" @disabled($book->stok < 1)>Keranjang</button>
                                        </div>
                                    </form>
                                @elseif (! auth()->check())
                                    <a class="btn btn-primary btn-sm mt-auto mb-2" href="{{ route('login') }}">Login untuk Pinjam</a>
                                @else
                                    <div class="alert alert-light border small mt-auto mb-2">Admin hanya dapat mengelola buku.</div>
                                @endif

                                @if (auth()->user()?->role === 'admin')
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('books.edit', $book) }}">Edit</a>
                                        <form method="post" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Hapus buku ini?')">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-outline-danger btn-sm" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Belum ada buku.</div></div>
        @endforelse
    </div>

    <div class="mt-4">{{ $books->links() }}</div>
</section>
@endsection
