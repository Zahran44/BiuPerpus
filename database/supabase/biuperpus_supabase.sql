-- BIUperpus Supabase Database
-- Jalankan file ini di Supabase SQL Editor.
-- File ini membuat tabel, relasi, index, dan data awal aplikasi.

create table if not exists public.users (
    id bigserial primary key,
    username varchar(255) not null unique,
    password varchar(255) not null,
    role varchar(255) not null default 'user' check (role in ('admin', 'user')),
    remember_token varchar(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

create table if not exists public.books (
    id bigserial primary key,
    judul varchar(255) not null,
    pengarang varchar(255) not null,
    penerbit varchar(255) not null,
    deskripsi text not null,
    tahun_terbit smallint not null,
    stok integer not null default 0,
    rental_fee numeric(12, 2) not null default 5000,
    cover varchar(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

create table if not exists public.genres (
    id bigserial primary key,
    nama_genre varchar(255) not null unique,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

create table if not exists public.book_genre (
    book_id bigint not null references public.books(id) on delete cascade,
    genre_id bigint not null references public.genres(id) on delete cascade,
    primary key (book_id, genre_id)
);

create table if not exists public.loans (
    id bigserial primary key,
    book_id bigint references public.books(id) on delete set null,
    nama_peminjam varchar(100) not null,
    tanggal_pinjam date not null,
    tanggal_kembali date,
    status varchar(255) not null default 'dipinjam'
        check (status in ('dipinjam', 'dikembalikan', 'menunggu_konfirmasi')),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

create table if not exists public.cart_items (
    id bigserial primary key,
    session_id varchar(255) not null,
    user_id bigint references public.users(id) on delete set null,
    book_id bigint not null references public.books(id) on delete cascade,
    quantity integer not null default 1,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    unique (session_id, book_id)
);

create index if not exists cart_items_session_id_index on public.cart_items(session_id);

create table if not exists public.payments (
    id bigserial primary key,
    invoice_number varchar(255) not null unique,
    nama_pembayar varchar(100) not null,
    payment_method varchar(255) not null default 'cash'
        check (payment_method in ('cash', 'transfer', 'qris')),
    status varchar(255) not null default 'pending'
        check (status in ('pending', 'paid', 'failed')),
    subtotal numeric(12, 2) not null default 0,
    total numeric(12, 2) not null default 0,
    paid_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

create table if not exists public.payment_items (
    id bigserial primary key,
    payment_id bigint not null references public.payments(id) on delete cascade,
    book_id bigint references public.books(id) on delete set null,
    judul_buku varchar(255) not null,
    quantity integer not null default 1,
    unit_price numeric(12, 2) not null default 0,
    subtotal numeric(12, 2) not null default 0,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

create table if not exists public.password_reset_tokens (
    username varchar(255) primary key,
    token varchar(255) not null,
    created_at timestamp(0) without time zone
);

create table if not exists public.sessions (
    id varchar(255) primary key,
    user_id bigint,
    ip_address varchar(45),
    user_agent text,
    payload text not null,
    last_activity integer not null
);

create index if not exists sessions_user_id_index on public.sessions(user_id);
create index if not exists sessions_last_activity_index on public.sessions(last_activity);

insert into public.users (id, username, password, role, created_at, updated_at) values
    (1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin', now(), now()),
    (2, 'user', '6ad14ba9986e3615423dfca256d04e3f', 'user', now(), now()),
    (3, 'ucup', 'f71a7b3794ee89dad17344b66dec77f5', 'user', now(), now()),
    (4, 'ahmad', '8de13959395270bf9d6819f818ab1a00', 'user', now(), now()),
    (5, 'kipli', 'bed023be47e474b04360f3516b63f596', 'user', now(), now())
on conflict (id) do nothing;

insert into public.books (id, judul, pengarang, penerbit, deskripsi, tahun_terbit, stok, rental_fee, cover, created_at, updated_at) values
    (22, 'BUMI', 'Tere liye', 'Gramedia', 'Bumi adalah novel fantasi karya Tere Liye dan buku pertama dari Serial Bumi. Ceritanya tentang Raib, remaja yang bisa menghilang, bersama Seli dan Ali dalam petualangan dunia paralel.', 2014, 31, 5000, '9786020332956_Bumi-New-Cover.jpg', now(), now()),
    (23, 'NEBULA', 'Tere liye', 'Gramedia', 'Nebula adalah novel lanjutan serial Bumi yang memperluas semesta dunia paralel, persahabatan, keberanian, dan pengorbanan.', 2020, 12, 5000, 'nebula.jpg', now(), now()),
    (24, 'Artificial Intelligence: A Modern Approach', 'Stuart J. Russell & Peter Norvig', 'Prentice Hal', 'Teks standar dunia tentang kecerdasan buatan yang membahas pencarian, pembelajaran mesin, logika, probabilitas, dan sistem multi-agen.', 2020, 40, 5000, 'book3.png', now(), now()),
    (25, 'AI Snake Oil', 'Arvind Narayanan & Sayash Kapoor', 'Princeton University Press', 'Buku non-fiksi yang membedah hype AI dan membedakan klaim teknologi yang realistis dari yang berlebihan.', 2024, 13, 5000, 'buku4.png', now(), now()),
    (26, 'Hello World: How to Be Human in the Age of the Machine', 'Janelle Shane', 'Voracious', 'Buku populer sains yang menjelaskan cara kerja AI melalui contoh ringan dan mudah dipahami.', 2019, 21, 5000, 'buku5.png', now(), now()),
    (27, 'Pengantar Teknologi Informasi', 'Muhammad Fairuzabadi dkk.', 'Get Press Indonesia', 'Gambaran luas tentang konsep TI dari arsitektur komputer, jaringan, pemrograman dasar, sistem operasi, hingga profesi teknologi.', 2023, 101, 5000, 'book6.png', now(), now()),
    (28, 'Pengantar Bisnis: Konsep dan Aplikasi', 'Widhy Wahyani dkk.', 'Get Press Indonesia', 'Gambaran komprehensif tentang konsep dasar bisnis, etika, tanggung jawab sosial, operasi, pemasaran, dan perilaku konsumen.', 2024, 54, 5000, 'book7.png', now(), now()),
    (29, 'Pengantar Bisnis (Graha Ilmu)', 'Roos Kities Andadari', 'ANDI', 'Pengetahuan teori bisnis yang dikaitkan dengan konteks Indonesia untuk mahasiswa dan pembaca pemula.', 2018, 12, 5000, 'book8.png', now(), now()),
    (30, 'Sophie''s World (Dunia Sophie)', 'Jostein Gaarder', 'Terjemahan Indonesia', 'Novel naratif yang memperkenalkan sejarah filsafat dari Yunani Kuno sampai pemikir modern melalui kisah Sophie.', 1991, 31, 5000, 'book9.png', now(), now()),
    (31, 'A History of Modern Indonesia Since c.1200', 'M.C. Ricklefs', 'Macmillan / Stanford University Press', 'Buku akademik tentang sejarah Indonesia dari abad ke-13 hingga periode modern dengan pendekatan penelitian sejarah mendalam.', 1981, 31, 5000, 'book10.png', now(), now())
on conflict (id) do nothing;

insert into public.genres (id, nama_genre, created_at, updated_at) values
    (1, 'Action & Adventure', now(), now()),
    (22, 'Fantasy', now(), now()),
    (39, 'IT', now(), now()),
    (41, 'Mystery', now(), now()),
    (51, 'Philosophy', now(), now()),
    (52, 'Quest', now(), now()),
    (59, 'History', now(), now()),
    (64, 'Non-Fiksi', now(), now()),
    (65, 'Business', now(), now()),
    (66, 'Education', now(), now())
on conflict (id) do nothing;

insert into public.book_genre (book_id, genre_id) values
    (22, 1), (22, 22),
    (23, 1), (23, 22), (23, 39), (23, 41),
    (24, 39), (24, 66),
    (25, 39), (25, 66),
    (26, 39), (26, 66),
    (27, 39), (27, 66),
    (28, 39), (28, 64), (28, 66),
    (29, 39), (29, 64), (29, 65), (29, 66),
    (30, 51), (30, 52), (30, 66),
    (31, 52), (31, 59), (31, 64), (31, 66)
on conflict (book_id, genre_id) do nothing;

insert into public.loans (id, book_id, nama_peminjam, tanggal_pinjam, tanggal_kembali, status, created_at, updated_at) values
    (22, 22, 'ucup', '2026-12-21', '2026-02-10', 'dikembalikan', now(), now()),
    (23, 31, 'kipli', '2026-02-10', null, 'dipinjam', now(), now()),
    (24, 24, 'kipli', '2026-11-02', null, 'dipinjam', now(), now()),
    (25, 28, 'ahmad', '2025-09-12', '2026-02-10', 'dikembalikan', now(), now()),
    (26, 23, 'ahmad', '2026-12-01', '2026-02-10', 'dikembalikan', now(), now())
on conflict (id) do nothing;

select setval(pg_get_serial_sequence('public.users', 'id'), coalesce((select max(id) from public.users), 1), true);
select setval(pg_get_serial_sequence('public.books', 'id'), coalesce((select max(id) from public.books), 1), true);
select setval(pg_get_serial_sequence('public.genres', 'id'), coalesce((select max(id) from public.genres), 1), true);
select setval(pg_get_serial_sequence('public.loans', 'id'), coalesce((select max(id) from public.loans), 1), true);
select setval(pg_get_serial_sequence('public.cart_items', 'id'), coalesce((select max(id) from public.cart_items), 1), true);
select setval(pg_get_serial_sequence('public.payments', 'id'), coalesce((select max(id) from public.payments), 1), true);
select setval(pg_get_serial_sequence('public.payment_items', 'id'), coalesce((select max(id) from public.payment_items), 1), true);
