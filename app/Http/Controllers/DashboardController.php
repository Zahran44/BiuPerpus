<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }

    public function admin()
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);

        $loanStatusCounts = Loan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $paymentMethodCounts = Payment::select('payment_method', DB::raw('count(*) as total'))
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        return view('dashboards.admin', [
            'totalBooks' => Book::count(),
            'totalUsers' => User::count(),
            'activeLoans' => Loan::where('status', 'dipinjam')->count(),
            'returnedLoans' => Loan::where('status', 'dikembalikan')->count(),
            'totalPayments' => Payment::count(),
            'paymentTotal' => Payment::where('status', 'paid')->sum('total'),
            'lowStockBooks' => Book::where('stok', '<=', 5)->orderBy('stok')->take(8)->get(),
            'recentLoans' => Loan::with('book')->latest()->take(8)->get(),
            'recentPayments' => Payment::with('items')->latest()->take(8)->get(),
            'recentUsers' => User::latest()->take(6)->get(),
            'popularBooks' => Book::withCount('loans')->orderByDesc('loans_count')->take(5)->get(),
            'loanStatusCounts' => $loanStatusCounts,
            'paymentMethodCounts' => $paymentMethodCounts,
        ]);
    }

    public function user()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $username = Auth::user()->username;

        return view('dashboards.user', [
            'recommendedBooks' => Book::with('genres')->where('stok', '>', 0)->latest()->take(6)->get(),
            'activeLoans' => Loan::with('book')
                ->where('nama_peminjam', $username)
                ->where('status', 'dipinjam')
                ->latest()
                ->get(),
            'loanHistory' => Loan::with('book')
                ->where('nama_peminjam', $username)
                ->latest()
                ->take(8)
                ->get(),
            'payments' => Payment::with('items')
                ->where('nama_pembayar', $username)
                ->latest()
                ->take(6)
                ->get(),
            'cartCount' => CartItem::where('session_id', request()->session()->getId())->sum('quantity'),
        ]);
    }
}
