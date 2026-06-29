<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('genres')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('judul', 'like', "%{$search}%")
                        ->orWhere('pengarang', 'like', "%{$search}%")
                        ->orWhereHas('genres', fn ($genreQuery) => $genreQuery->where('nama_genre', 'like', "%{$search}%"));
                });
            })
            ->orderBy('judul')
            ->paginate(12)
            ->withQueryString();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('books.form', [
            'book' => new Book(),
            'genres' => Genre::orderBy('nama_genre')->get(),
            'selectedGenres' => [],
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $book = Book::create($this->validatedData($request));
        $this->syncGenres($book, $request);

        return redirect()->route('books.index')->with('status', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $this->ensureAdmin();

        return view('books.form', [
            'book' => $book,
            'genres' => Genre::orderBy('nama_genre')->get(),
            'selectedGenres' => $book->genres()->pluck('genres.id')->all(),
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $this->ensureAdmin();

        $book->update($this->validatedData($request, $book));
        $this->syncGenres($book, $request);

        return redirect()->route('books.index')->with('status', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $this->ensureAdmin();

        $book->delete();

        return redirect()->route('books.index')->with('status', 'Buku berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Book $book = null): array
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'pengarang' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'tahun_terbit' => ['required', 'integer', 'min:1000', 'max:'.date('Y')],
            'stok' => ['required', 'integer', 'min:0'],
            'rental_fee' => ['required', 'numeric', 'min:0'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('public/covers');
            $data['cover'] = basename($path);
        } elseif ($book) {
            $data['cover'] = $book->cover;
        }

        return $data;
    }

    private function syncGenres(Book $book, Request $request): void
    {
        $genreIds = collect($request->input('genres', []))
            ->map(fn ($genreName) => Genre::firstOrCreate(['nama_genre' => $genreName])->id)
            ->all();

        $book->genres()->sync($genreIds);
    }

    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);
    }
}
