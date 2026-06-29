<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            ['id' => 1, 'username' => 'admin', 'password' => '0192023a7bbd73250516f069df18b500', 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'username' => 'user', 'password' => '6ad14ba9986e3615423dfca256d04e3f', 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'username' => 'ucup', 'password' => 'f71a7b3794ee89dad17344b66dec77f5', 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'username' => 'ahmad', 'password' => '8de13959395270bf9d6819f818ab1a00', 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'username' => 'kipli', 'password' => 'bed023be47e474b04360f3516b63f596', 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('books')->insert([
            ['id' => 22, 'judul' => 'BUMI', 'pengarang' => 'Tere liye', 'penerbit' => 'Gramedia', 'deskripsi' => 'Bumi adalah novel fantasi karya Tere Liye dan buku pertama dari Serial Bumi. Ceritanya tentang Raib, remaja yang bisa menghilang, bersama Seli dan Ali dalam petualangan dunia paralel.', 'tahun_terbit' => 2014, 'stok' => 31, 'cover' => '9786020332956_Bumi-New-Cover.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'judul' => 'NEBULA', 'pengarang' => 'Tere liye', 'penerbit' => 'Gramedia', 'deskripsi' => 'Nebula adalah novel lanjutan serial Bumi yang memperluas semesta dunia paralel, persahabatan, keberanian, dan pengorbanan.', 'tahun_terbit' => 2020, 'stok' => 12, 'cover' => 'nebula.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'judul' => 'Artificial Intelligence: A Modern Approach', 'pengarang' => 'Stuart J. Russell & Peter Norvig', 'penerbit' => 'Prentice Hal', 'deskripsi' => 'Teks standar dunia tentang kecerdasan buatan yang membahas pencarian, pembelajaran mesin, logika, probabilitas, dan sistem multi-agen.', 'tahun_terbit' => 2020, 'stok' => 40, 'cover' => 'book3.png', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'judul' => 'AI Snake Oil', 'pengarang' => 'Arvind Narayanan & Sayash Kapoor', 'penerbit' => 'Princeton University Press', 'deskripsi' => 'Buku non-fiksi yang membedah hype AI dan membedakan klaim teknologi yang realistis dari yang berlebihan.', 'tahun_terbit' => 2024, 'stok' => 13, 'cover' => 'buku4.png', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'judul' => 'Hello World: How to Be Human in the Age of the Machine', 'pengarang' => 'Janelle Shane', 'penerbit' => 'Voracious', 'deskripsi' => 'Buku populer sains yang menjelaskan cara kerja AI melalui contoh ringan dan mudah dipahami.', 'tahun_terbit' => 2019, 'stok' => 21, 'cover' => 'buku5.png', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'judul' => 'Pengantar Teknologi Informasi', 'pengarang' => 'Muhammad Fairuzabadi dkk.', 'penerbit' => 'Get Press Indonesia', 'deskripsi' => 'Gambaran luas tentang konsep TI dari arsitektur komputer, jaringan, pemrograman dasar, sistem operasi, hingga profesi teknologi.', 'tahun_terbit' => 2023, 'stok' => 101, 'cover' => 'book6.png', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'judul' => 'Pengantar Bisnis: Konsep dan Aplikasi', 'pengarang' => 'Widhy Wahyani dkk.', 'penerbit' => 'Get Press Indonesia', 'deskripsi' => 'Gambaran komprehensif tentang konsep dasar bisnis, etika, tanggung jawab sosial, operasi, pemasaran, dan perilaku konsumen.', 'tahun_terbit' => 2024, 'stok' => 54, 'cover' => 'book7.png', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'judul' => 'Pengantar Bisnis (Graha Ilmu)', 'pengarang' => 'Roos Kities Andadari', 'penerbit' => 'ANDI', 'deskripsi' => 'Pengetahuan teori bisnis yang dikaitkan dengan konteks Indonesia untuk mahasiswa dan pembaca pemula.', 'tahun_terbit' => 2018, 'stok' => 12, 'cover' => 'book8.png', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'judul' => "Sophie's World (Dunia Sophie)", 'pengarang' => 'Jostein Gaarder', 'penerbit' => 'Terjemahan Indonesia', 'deskripsi' => 'Novel naratif yang memperkenalkan sejarah filsafat dari Yunani Kuno sampai pemikir modern melalui kisah Sophie.', 'tahun_terbit' => 1991, 'stok' => 31, 'cover' => 'book9.png', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'judul' => 'A History of Modern Indonesia Since c.1200', 'pengarang' => 'M.C. Ricklefs', 'penerbit' => 'Macmillan / Stanford University Press', 'deskripsi' => 'Buku akademik tentang sejarah Indonesia dari abad ke-13 hingga periode modern dengan pendekatan penelitian sejarah mendalam.', 'tahun_terbit' => 1981, 'stok' => 31, 'cover' => 'book10.png', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('genres')->insert([
            ['id' => 1, 'nama_genre' => 'Action & Adventure', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'nama_genre' => 'Fantasy', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'nama_genre' => 'IT', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 41, 'nama_genre' => 'Mystery', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 51, 'nama_genre' => 'Philosophy', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 52, 'nama_genre' => 'Quest', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 59, 'nama_genre' => 'History', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 64, 'nama_genre' => 'Non-Fiksi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 65, 'nama_genre' => 'Business', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 66, 'nama_genre' => 'Education', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('book_genre')->insert([
            ['book_id' => 22, 'genre_id' => 1], ['book_id' => 22, 'genre_id' => 22],
            ['book_id' => 23, 'genre_id' => 1], ['book_id' => 23, 'genre_id' => 22], ['book_id' => 23, 'genre_id' => 39], ['book_id' => 23, 'genre_id' => 41],
            ['book_id' => 24, 'genre_id' => 39], ['book_id' => 24, 'genre_id' => 66],
            ['book_id' => 25, 'genre_id' => 39], ['book_id' => 25, 'genre_id' => 66],
            ['book_id' => 26, 'genre_id' => 39], ['book_id' => 26, 'genre_id' => 66],
            ['book_id' => 27, 'genre_id' => 39], ['book_id' => 27, 'genre_id' => 66],
            ['book_id' => 28, 'genre_id' => 39], ['book_id' => 28, 'genre_id' => 64], ['book_id' => 28, 'genre_id' => 66],
            ['book_id' => 29, 'genre_id' => 39], ['book_id' => 29, 'genre_id' => 64], ['book_id' => 29, 'genre_id' => 65], ['book_id' => 29, 'genre_id' => 66],
            ['book_id' => 30, 'genre_id' => 51], ['book_id' => 30, 'genre_id' => 52], ['book_id' => 30, 'genre_id' => 66],
            ['book_id' => 31, 'genre_id' => 52], ['book_id' => 31, 'genre_id' => 59], ['book_id' => 31, 'genre_id' => 64], ['book_id' => 31, 'genre_id' => 66],
        ]);

        DB::table('loans')->insert([
            ['id' => 22, 'book_id' => 22, 'nama_peminjam' => 'ucup', 'tanggal_pinjam' => '2026-12-21', 'tanggal_kembali' => '2026-02-10', 'status' => 'dikembalikan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'book_id' => 31, 'nama_peminjam' => 'kipli', 'tanggal_pinjam' => '2026-02-10', 'tanggal_kembali' => null, 'status' => 'dipinjam', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'book_id' => 24, 'nama_peminjam' => 'kipli', 'tanggal_pinjam' => '2026-11-02', 'tanggal_kembali' => null, 'status' => 'dipinjam', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'book_id' => 28, 'nama_peminjam' => 'ahmad', 'tanggal_pinjam' => '2025-09-12', 'tanggal_kembali' => '2026-02-10', 'status' => 'dikembalikan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'book_id' => 23, 'nama_peminjam' => 'ahmad', 'tanggal_pinjam' => '2026-12-01', 'tanggal_kembali' => '2026-02-10', 'status' => 'dikembalikan', 'created_at' => now(), 'updated_at' => now()],
        ]);

        if (DB::getDriverName() === 'pgsql') {
            foreach (['users', 'books', 'genres', 'loans'] as $table) {
                DB::statement("SELECT setval(pg_get_serial_sequence('{$table}', 'id'), COALESCE(MAX(id), 1), true) FROM {$table}");
            }
        }
    }
}
