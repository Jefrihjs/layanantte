@extends('layouts.app')

@section('page_title', 'Tambah Verifikator Baru')

@section('content')
<div class="container-fluid p-0">
    
    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('users.index') }}" class="btn btn-light rounded-pill px-4 fw-bold border shadow-sm">
            <i class="fa-solid fa-arrow-left me-2 text-muted"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                
                {{-- Bagian Header Card --}}
                <div class="p-4 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-user-plus text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Registrasi Verifikator</h5>
                            <p class="mb-0 small text-white-50">Silakan lengkapi data akun untuk akses sistem.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5 bg-white">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            {{-- NAMA --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-muted small text-uppercase mb-2">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 rounded-start-4 px-3">
                                        <i class="fa-solid fa-id-card text-primary"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control bg-light border-0 rounded-end-4 py-3 @error('name') is-invalid @enderror" 
                                           placeholder="Masukkan nama lengkap..." value="{{ old('name') }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- EMAIL --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase mb-2">Alamat Email (Login)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 rounded-start-4 px-3">
                                        <i class="fa-solid fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control bg-light border-0 rounded-end-4 py-3 @error('email') is-invalid @enderror" 
                                           placeholder="contoh@beltim.go.id" value="{{ old('email') }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- ROLE (Sangat Penting karena tadi belum masuk DB) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase mb-2">Level Akses (Role)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 rounded-start-4 px-3">
                                        <i class="fa-solid fa-user-shield text-primary"></i>
                                    </span>
                                    <select name="role" class="form-select bg-light border-0 rounded-end-4 py-3" required>
                                        <option value="user" selected>Verifikator (User)</option>
                                        <option value="admin">Administrator (Admin)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- PASSWORD --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-muted small text-uppercase mb-2">Password Awal</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 rounded-start-4 px-3">
                                        <i class="fa-solid fa-lock text-primary"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control bg-light border-0 rounded-end-4 py-3 @error('password') is-invalid @enderror" 
                                           placeholder="Minimal 8 karakter..." required>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <small class="text-muted mt-2 d-block italic">Password ini akan digunakan user untuk login pertama kali.</small>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-5 pt-4 border-top d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light rounded-pill px-4 fw-bold border">Reset Form</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm" style="background: #2563eb;">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Simpan User Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection