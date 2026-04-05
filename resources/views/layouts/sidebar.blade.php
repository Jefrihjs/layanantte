<aside class="sidebar-2026">
    <div class="sidebar-header text-center">
        <img src="{{ asset('img/logo-beltim.png') }}" alt="Logo Beltim" style="height: 60px; margin-bottom: 15px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3)); transition: 0.3s;">
        <h6 class="text-label" style="font-size: 14px; letter-spacing: 3px; font-weight: 800; color: #ffffff; margin: 0; text-transform: uppercase;">TTE-BELTIM</h6>
    </div>

    <nav class="nav flex-column mt-4">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i> 
            <span class="text-label">Dashboard</span>
        </a>
        <a href="{{ route('permohonan.index') }}" class="nav-link {{ request()->routeIs('permohonan.*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-shield"></i> 
            <span class="text-label">Permohonan</span>
        </a>

        @if(auth()->user()->role == 'admin' || auth()->user()->id == 1) 
            <div class="admin-label px-4 mt-4 mb-2 small text-muted fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 10px;">
                <span class="text-label">Admin Control</span>
            </div>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> 
                <span class="text-label">Kelola User</span>
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
    {{-- TAMBAHKAN mb-3 DI SINI --}}
        <a href="{{ route('profile.edit') }}" class="mb-3 px-2 text-decoration-none group-user" style="transition: 0.3s;">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" 
                style="width: 35px; height: 35px; box-shadow: 0 0 10px rgba(37, 99, 235, 0.4);">
                <i class="fa-solid fa-user text-white" style="font-size: 14px;"></i>
            </div>
            <div class="overflow-hidden text-label">
                <p class="small text-white fw-bold m-0 text-truncate">{{ auth()->user()->name }}</p>
                <p class="text-white-50 m-0" style="font-size: 10px;">Profil Saya</p>
            </div>
        </a>

        {{-- TOMBOL LOGOUT --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm w-100 fw-bold py-2 border-0 text-white btn-logout-custom d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-power-off"></i> 
                <span class="text-label ms-2">Keluar</span>
            </button>
        </form>
    </div>
</aside>

<style>
    /* CSS Tambahan khusus untuk handle efek Collapsed pada elemen Sidebar */
    .sidebar-2026.collapsed .text-label, 
    .sidebar-2026.collapsed .admin-label {
        display: none !important;
    }

    .sidebar-2026.collapsed .sidebar-header {
        padding: 20px 10px !important;
    }

    .sidebar-2026.collapsed .sidebar-header img {
        height: 40px !important;
        margin-bottom: 0;
    }

    .sidebar-2026.collapsed .nav-link {
        justify-content: center;
        margin: 8px 10px !important;
        padding: 14px 0 !important;
    }

    .sidebar-2026.collapsed .nav-link i {
        font-size: 18px;
    }

    .sidebar-2026.collapsed .sidebar-footer {
        padding: 15px 10px !important;
    }

    /* Animasi logout saat mengecil */
    .sidebar-2026.collapsed .btn-logout-custom {
        padding: 10px 0 !important;
    }

    .group-user:hover { opacity: 0.8; transform: translateX(3px); }
    .btn-logout-custom { background: rgba(220, 38, 38, 0.2); border-radius: 12px; transition: 0.3s; }
    .btn-logout-custom:hover { background: rgba(220, 38, 38, 0.4) !important; color: #ff4d4d !important; }
</style>