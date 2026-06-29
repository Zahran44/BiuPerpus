<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->items($request);

        return view('cart.index', [
            'items' => $items,
            'subtotal' => $items->sum(fn (CartItem $item) => $item->subtotal()),
        ]);
    }

    public function store(Request $request, Book $book)
    {
        $this->ensureUserCanBorrow();

        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        if ($book->stok < 1) {
            return back()->withErrors(['quantity' => 'Stok buku sedang kosong.']);
        }

        $quantity = min($data['quantity'] ?? 1, $book->stok);

        $item = CartItem::firstOrNew([
            'session_id' => $request->session()->getId(),
            'book_id' => $book->id,
        ]);

        $item->fill([
            'user_id' => Auth::id(),
            'quantity' => min(($item->quantity ?: 0) + $quantity, $book->stok),
        ])->save();

        return redirect()->route('cart.index')->with('status', 'Buku masuk ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->abortIfDifferentSession($request, $cartItem);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cartItem->update([
            'quantity' => min($data['quantity'], $cartItem->book->stok),
        ]);

        return redirect()->route('cart.index')->with('status', 'Keranjang diperbarui.');
    }

    public function destroy(Request $request, CartItem $cartItem)
    {
        $this->abortIfDifferentSession($request, $cartItem);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('status', 'Item dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $this->ensureUserCanBorrow();

        $data = $request->validate([
            'nama_pembayar' => ['required', 'string', 'max:100'],
            'payment_method' => ['required', 'in:cash,transfer,qris'],
        ]);

        $items = $this->items($request);

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['checkout' => 'Keranjang masih kosong.']);
        }

        foreach ($items as $item) {
            if ($item->quantity > $item->book->stok) {
                return back()->withErrors(['checkout' => "Stok {$item->book->judul} tidak mencukupi."]);
            }
        }

        $payment = DB::transaction(function () use ($items, $data) {
            $subtotal = $items->sum(fn (CartItem $item) => $item->subtotal());

            $payment = Payment::create([
                'invoice_number' => 'INV-'.now()->format('YmdHis').'-'.random_int(100, 999),
                'nama_pembayar' => $data['nama_pembayar'],
                'payment_method' => $data['payment_method'],
                'status' => 'paid',
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'paid_at' => now(),
            ]);

            foreach ($items as $item) {
                $payment->items()->create([
                    'book_id' => $item->book_id,
                    'judul_buku' => $item->book->judul,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->book->rental_fee,
                    'subtotal' => $item->subtotal(),
                ]);

                for ($i = 0; $i < $item->quantity; $i++) {
                    Loan::create([
                        'book_id' => $item->book_id,
                        'nama_peminjam' => $data['nama_pembayar'],
                        'tanggal_pinjam' => now()->toDateString(),
                        'status' => 'dipinjam',
                    ]);
                }

                $item->book->decrement('stok', $item->quantity);
                $item->delete();
            }

            return $payment;
        });

        return redirect()->route('payments.show', $payment)->with('status', 'Payment berhasil dan peminjaman tercatat.');
    }

    public function showPayment(Payment $payment)
    {
        return view('payments.show', [
            'payment' => $payment->load('items'),
        ]);
    }

    public function payments()
    {
        return view('payments.index', [
            'payments' => Payment::latest()->paginate(15),
        ]);
    }

    private function items(Request $request)
    {
        return CartItem::with('book')
            ->where('session_id', $request->session()->getId())
            ->latest()
            ->get();
    }

    private function abortIfDifferentSession(Request $request, CartItem $cartItem): void
    {
        abort_unless($cartItem->session_id === $request->session()->getId(), 403);
    }

    private function ensureUserCanBorrow(): void
    {
        abort_unless(Auth::check() && Auth::user()->role === 'user', 403);
    }
}
