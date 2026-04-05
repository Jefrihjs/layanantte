@extends('layouts.app')

@section('page_title', 'Edit User Verifikator')

@section('content')
<style>
    .form-card-user {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }
    .form-label-custom {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-control-custom {
        border-radius: 12px;
        padding: 12px 15px;
        border: 2px solid #f1f5f9;
        background-color: #f8fafc;
        transition: all 0.3s ease;
    }
    .form-control-custom:focus {
        border-color: #0f766e;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1);
    }
    .btn-update {
        background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        transition: 0.3s;
    }
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(15, 118, 110, 0.3);
        color: white;
    }
</style>

<div class="container-fluid p-0">
    
    {{-- HEADER AREA --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('users.index') }}" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="fa-solid fa-arrow-left text-muted"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0 text-dark">Edit Data User</h4>
            <p class="text-muted small mb-0">Memperbarui informasi akun: <strong>{{ $user->name }}</strong></p>
        </div>
    </div>

    <div class="card form-card-user border-0">
        <div class="card-body p-5">
            
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- NAMA --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label-custom"><i class="fa-solid fa-user me-2 text-teal"></i>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required placeholder="Contoh: Budi Santoso">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- EMAIL --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label-custom"><i class="fa-solid fa-envelope me-2 text-teal"></i>Email Login</label>
                            <input type="email" name="email" class="form-control form-control-custom @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required placeholder="email@beltim.go.id">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- ROLE --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label-custom"><i class="fa-solid fa-user-shield me-2 text-teal"></i>Level Akses (Role)</label>
                            <select name="role" class="form-select form-control-custom @error('role') is-invalid @enderror" required>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User (Verifikator Biasa)</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Super Admin)</option>
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted mt-2 d-block">Admin dapat mengakses menu "Kelola User" dan meriset password.</small>
                        </div>
                    </div>

                    {{-- INFO TAMBAHAN --}}
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="p-3 rounded-4 bg-light border-0 w-100">
                            <small class="text-muted italic">
                                <i class="fa-solid fa-circle-info me-1"></i> 
                                Perubahan email akan berdampak pada kredensial login user yang bersangkutan.
                            </small>
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="d-flex justify-content-end gap-2 mt-5 pt-4 border-top">
                    <a href="{{ route('users.index') }}" class="btn btn-light rounded-pill px-4 fw-bold text-muted border">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-update rounded-pill shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan User
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection