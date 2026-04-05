@extends('layouts.app')

@section('page_title', 'Profil Saya')

@section('content')
<style>
    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .form-label-sm {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .form-control-profile {
        border-radius: 12px;
        border: 2px solid #f1f5f9;
        padding: 12px;
        transition: 0.3s;
    }
    .form-control-profile:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1);
    }
    .section-header {
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
</style>

<div class="container-fluid p-0">
    <div class="row g-4">
        
        {{-- KIRI: INFORMASI PROFIL --}}
        <div class="col-lg-6">
            <div class="card profile-card border-0">
                <div class="card-body p-4">
                    <div class="section-header d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-gear text-teal" style="color: #0f766e;"></i>
                        <h5 class="fw-bold m-0">Informasi Profil</h5>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label class="form-label-sm">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-profile" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-sm">Email Layanan</label>
                            <input type="email" name="email" class="form-control form-control-profile" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" style="background: #0f766e; border: none;">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- KANAN: KEAMANAN (GANTI PASSWORD) --}}
        <div class="col-lg-6" id="security">
            <div class="card profile-card border-0">
                <div class="card-body p-4">
                    <div class="section-header d-flex align-items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-warning"></i>
                        <h5 class="fw-bold m-0">Keamanan Akun</h5>
                    </div>

                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label class="form-label-sm">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control form-control-profile" placeholder="••••••••">
                        </div>

                        <div class="mb-3">
                            <label class="form-label-sm">Password Baru</label>
                            <input type="password" name="password" class="form-control form-control-profile" placeholder="Minimal 8 karakter">
                        </div>

                        <div class="mb-4">
                            <label class="form-label-sm">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-profile" placeholder="Ulangi password baru">
                        </div>

                        <button type="submit" class="btn btn-warning text-dark rounded-pill px-4 fw-bold shadow-sm border-0">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ALERT BERHASIL --}}
@if (session('status') === 'profile-updated' || session('status') === 'password-updated')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data profil Anda telah diperbarui.',
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
@endif
@endsection