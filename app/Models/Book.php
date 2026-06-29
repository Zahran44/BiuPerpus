<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'deskripsi',
        'tahun_terbit',
        'stok',
        'rental_fee',
        'cover',
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function coverUrl(): string
    {
        if (! $this->cover) {
            return asset('assets/img/logo2.png');
        }

        if (Storage::disk('public')->exists('covers/'.$this->cover)) {
            return Storage::url('covers/'.$this->cover);
        }

        return asset('assets/img/covers/'.$this->cover);
    }
}
