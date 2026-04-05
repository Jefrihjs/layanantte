@extends('layouts.app')

@section('page_title', 'Manajemen User Verifikator')

@section('content')
<div class="container-fluid p-0">
    
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Daftar Verifikator</h4>
            <p class="text-muted small mb-0">Kelola akun admin dan verifikator layanan TTE.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold border-0" style="background: #0f766e;">
            <i class="fa-solid fa-user-plus me-2"></i> Tambah User Baru
        </a>
    </div>

    {{-- TABEL USER --}}
    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 small fw-bold text-muted text-uppercase">Nama User</th>
                    <th class="py-3 small fw-bold text-muted text-uppercase">Email Login</th>
                    <th class="py-3 small fw-bold text-muted text-uppercase text-center">Role</th>
                    <th class="py-3 small fw-bold text-muted text-uppercase text-center">Status</th>
                    <th class="pe-4 py-3 small fw-bold text-muted text-uppercase text-center">Aksi Kontrol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: 800;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">
                        {{-- Badge Role --}}
                        @if($user->role == 'admin')
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill" style="font-size: 10px;">ADMIN</span>
                        @else
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill" style="font-size: 10px;">USER</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill" style="font-size: 10px;">AKTIF</span>
                    </td>
                    <td class="pe-4 text-center">
                        <div class="d-flex justify-content-center gap-1">
                            {{-- Tombol Reset Password --}}
                            <button onclick="promptReset('{{ $user->id }}', '{{ $user->name }}')" 
                                    class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold shadow-none" 
                                    style="font-size: 11px; border: 2px solid #fee2e2;" title="Reset Password">
                                <i class="fa-solid fa-key"></i>
                            </button>
                            
                            {{-- Edit User --}}
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-light border rounded-pill" title="Edit User">
                                <i class="fa-solid fa-user-pen text-primary"></i>
                            </a>

                            {{-- Hapus User (Kecuali Akun Sendiri) --}}
                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="form-hapus-user d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-light border rounded-pill btn-delete-user" title="Hapus User">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

{{-- Form Tersembunyi untuk Proses Reset ke UserController --}}
<form id="formResetPassword" method="POST" style="display:none;">
    @csrf 
    @method('PUT')
    <input type="hidden" name="password" id="newPassword">
</form>

@endsection

@push('scripts')
<script>
    // 1. FUNGSI RESET PASSWORD
    function promptReset(userId, userName) {
        Swal.fire({
            title: 'Reset Password Verifikator',
            text: "Masukkan password baru untuk " + userName,
            input: 'password',
            inputPlaceholder: 'Minimal 8 karakter...',
            showCancelButton: true,
            confirmButtonText: 'Update Sekarang',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#0f766e',
            cancelButtonColor: '#64748b',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            inputValidator: (value) => {
                if (!value || value.length < 8) {
                    return 'Password harus diisi minimal 8 karakter!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                const form = document.getElementById('formResetPassword');
                form.action = `/admin/users/${userId}/reset-password`;
                document.getElementById('newPassword').value = result.value;
                form.submit();
            }
        });
    }

    // 2. FUNGSI KONFIRMASI HAPUS (TAMBAHKAN INI)
    document.querySelectorAll('.btn-delete-user').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.form-hapus-user');
            
            Swal.fire({
                title: 'Hapus akun ini?',
                text: "User tidak akan bisa login lagi ke sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah tegas untuk hapus
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // 3. NOTIFIKASI SUKSES
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Waduh!',
            text: "{{ session('error') }}",
        });
    @endif
</script>
@endpush