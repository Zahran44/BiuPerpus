@extends('layouts.app')

@section('title', ($book->exists ? 'Edit Buku' : 'Tambah Buku').' - BIUperpus')

@section('content')
<section class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h4 fw-bold mb-4">{{ $book->exists ? 'Edit Buku' : 'Tambah Buku' }}</h1>
                    <form method="post" action="{{ $book->exists ? route('books.update', $book) : route('books.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if ($book->exists)
                            @method('put')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Judul</label>
                                <input class="form-control" name="judul" value="{{ old('judul', $book->judul) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tahun Terbit</label>
                                <input class="form-control" type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $book->tahun_terbit) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pengarang</label>
                                <input class="form-control" name="pengarang" value="{{ old('pengarang', $book->pengarang) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Penerbit</label>
                                <input class="form-control" name="penerbit" value="{{ old('penerbit', $book->penerbit) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Stok</label>
                                <input class="form-control" type="number" min="0" name="stok" value="{{ old('stok', $book->stok ?? 0) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Biaya Sewa</label>
                                <input class="form-control" type="number" min="0" step="500" name="rental_fee" value="{{ old('rental_fee', $book->rental_fee ?? 5000) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cover</label>
                                <input class="form-control" type="file" name="cover" accept="image/*">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="5" required>{{ old('deskripsi', $book->deskripsi) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Genre</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @php
                                        $selectedGenreValues = old('genres', $selectedGenres);
                                    @endphp
                                    @foreach ($genres as $genre)
                                        <label class="btn btn-outline-secondary btn-sm">
                                            <input type="checkbox" class="form-check-input me-1" name="genres[]" value="{{ $genre->nama_genre }}" @checked(in_array($genre->id, $selectedGenreValues) || in_array($genre->nama_genre, $selectedGenreValues))>
                                            {{ $genre->nama_genre }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a class="btn btn-outline-secondary" href="{{ route('books.index') }}">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
