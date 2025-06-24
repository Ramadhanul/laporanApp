@extends('layouts.bootstrap-app')

@section('content')
    <h2 class="mb-4">Profil Saya</h2>

    {{-- Informasi Akun --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Informasi Akun
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}" class="row g-3">
                @csrf
                @method('patch')

                <div class="col-md-6">
                    <label for="name" class="form-label">Nama</label>
                    <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}"
                           class="form-control @error('name') is-invalid @enderror" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}"
                           class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Ubah Password --}}
    <div class="card mb-4">
        <div class="card-header bg-warning">
            Ubah Password
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}" class="row g-3">
                @csrf
                @method('put')

                <div class="col-md-6">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password"
                           class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-control" required>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-warning">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Hapus Akun --}}
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            Hapus Akun
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Yakin ingin menghapus akun?');">
                @csrf
                @method('delete')

                <p class="mb-3">Akun akan dihapus secara permanen. Tindakan ini tidak bisa dibatalkan.</p>

                <button type="submit" class="btn btn-danger">Hapus Akun</button>
            </form>
        </div>
    </div>
@endsection
