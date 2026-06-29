<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('book')->latest()->paginate(15);

        return view('loans.index', compact('loans'));
    }

    public function borrow(Request $request, Book $book)
    {
        abort_unless(Auth::check() && Auth::user()->role === 'user', 403);

        $data = $request->validate([
            'nama_peminjam' => ['required', 'string', 'max:100'],
            'tanggal_pinjam' => ['required', 'date'],
        ]);

        if ($book->stok < 1) {
            return back()->withErrors(['nama_peminjam' => 'Stok buku sedang kosong.']);
        }

        Loan::create([
            'book_id' => $book->id,
            'nama_peminjam' => $data['nama_peminjam'],
            'tanggal_pinjam' => $data['tanggal_pinjam'],
            'status' => 'dipinjam',
        ]);

        $book->decrement('stok');

        return redirect()->route('books.index')->with('status', 'Peminjaman berhasil dicatat.');
    }

    public function return(Loan $loan)
    {
        if ($loan->status !== 'dikembalikan') {
            $loan->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now()->toDateString(),
            ]);

            $loan->book?->increment('stok');
        }

        return redirect()->route('loans.index')->with('status', 'Pengembalian berhasil dicatat.');
    }
}
