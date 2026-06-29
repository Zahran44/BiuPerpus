<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;

class HomeController extends Controller
{
    public function index()
    {
        $favoriteBooks = Book::withCount(['loans as total_pinjam' => fn ($query) => $query->where('status', 'dikembalikan')])
            ->orderByDesc('total_pinjam')
            ->take(4)
            ->get();

        return view('home', [
            'favoriteBooks' => $favoriteBooks,
            'totalBooks' => Book::count(),
            'totalGenres' => Genre::count(),
            'newBooks' => Book::latest()->take(6)->get(),
        ]);
    }
}
