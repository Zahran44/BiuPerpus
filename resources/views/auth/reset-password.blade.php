@extends('layouts.app')

@section('title', 'Reset Password - BIUperpus')

@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h4 fw-bold mb-3">Reset Password</h1>
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input class="form-control" name="username" value="{{ old('username') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input class="form-control" type="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input class="form-control" type="password" name="password_confirmation" required>
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Simpan Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
