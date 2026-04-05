<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTE-BELTIM | @yield('page_title', 'Dashboard')</title>

    {{-- 1. FRAMEWORK UTAMA --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
    :root {
        --sidebar-navy: #0f172a;
        --primary-blue: #2563eb;
        --bg-body: #f8fafc;
        --sidebar-width: 280px;
        --sidebar-collapsed-width: 85px;
    }

    body { 
        background-color: var(--bg-body) !important; 
        font-family: 'Inter', sans-serif; 
        margin: 0; 
        overflow-x: hidden; 
    }

    /* --- SIDEBAR STYLE --- */
    .sidebar-2026 {
        width: var(--sidebar-width) !important; 
        height: 100vh; 
        position: fixed;
        top: 0;
        left: 0;
        background: var(--sidebar-navy); 
        color: white; 
        z-index: 1040;
        display: flex; 
        flex-direction: column; 
        /* INI KUNCINYA: Memaksa konten atas dan bawah terpisah jauh */
        justify-content: space-between; 
        border-right: 1px solid rgba(255,255,255,0.05);
        box-shadow: 4px 0 15px rgba(0,0,0,0.15);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 20px 0; 
    }

    .sidebar-2026.collapsed {
        width: var(--sidebar-collapsed-width) !important;
    }

    /* --- MAIN CONTENT ADJUSTMENT --- */
    .main-content { 
        margin-left: var(--sidebar-width) !important; 
        min-height: 100vh; 
        width: calc(100% - var(--sidebar-width)); 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .main-content.expanded {
        margin-left: var(--sidebar-collapsed-width) !important;
        width: calc(100% - var(--sidebar-collapsed-width));
    }

    .navbar-custom { 
        background: white; 
        padding: 15px 30px; 
        border-bottom: 1px solid #e2e8f0; 
        position: sticky; 
        top: 0; 
        z-index: 1060; /* Harus paling tinggi agar tombol toggle selalu bisa diklik */
    }

    /* Utilitas tambahan untuk Toggle */
    .sidebar-2026.collapsed .sidebar-header h6,
    .sidebar-2026.collapsed .nav-link span,
    .sidebar-2026.collapsed .sidebar-footer .text-label {
        display: none !important;
    }

    .sidebar-2026.collapsed .nav-link {
        justify-content: center !important; /* Paksa ke tengah horizontal */
        padding: 15px 0 !important;
        margin: 8px 10px !important;
        display: flex !important;
        align-items: center !important; /* Paksa ke tengah vertikal */
    }

    .sidebar-2026.collapsed .nav-link i {
        margin: 0 !important; /* Buang margin kanan ikon agar tidak berat sebelah */
        font-size: 20px !important;
        width: auto !important; /* Biarkan lebar ikon otomatis agar presisi */
        display: block !important;
    }

    .sidebar-2026.collapsed .sidebar-header {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        padding: 20px 0 !important;
    }

    .sidebar-2026.collapsed .sidebar-header img {
        margin: 0 !important; 
        height: 40px !important;
    }

    .sidebar-2026.collapsed .sidebar-footer {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        padding: 20px 10px !important;
        padding-top: 30px !important; 
        padding-bottom: 30px !important;
    }

    .sidebar-2026.collapsed .group-user {
        justify-content: center !important;
        margin: 0 0 15px 0 !important;
        width: 100%;
        margin-bottom: 20px !important;
    }

    .sidebar-2026.collapsed .group-user div:first-child {
        margin-right: 0 !important; /* Buang margin kanan avatar agar tidak miring */
    }

    .group-user {
        margin-bottom: 20px !important; /* Memberi jarak ke tombol logout di bawahnya */
        display: flex;
        align-items:center;
        gap:8px;
    }


    .sidebar-2026.collapsed .btn-logout-custom {
        padding: 12px 0 !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    .sidebar-footer {
        padding: 20px !important;
        background: rgba(0,0,0,0.2);
        border-top: 1px solid rgba(255,255,255,0.05);
    }

    .hide-caret::after { display: none !important; }
    .navbar-custom .dropdown-item:hover { background-color: #f8fafc; transform: translateX(5px); transition: all 0.2s ease; }
    
    /* Style Tombol Toggle agar lebih terlihat */
    #btnToggle {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        transition: 0.2s;
    }
    #btnToggle:hover {
        background: #e2e8f0;
        color: var(--primary-blue);
    }

    .stats-grid-new {
        display: grid !important; /* Gunakan Grid, lebih stabil dari Flex */
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)) !important;
        gap: 20px;
        margin-bottom: 30px;
        width: 100%;
    }

    .stat-card-new {
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-radius: 24px; /* Lebih bulat agar modern */
        padding: 25px !important;
        color: white !important;
        text-decoration: none !important;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        min-height: 160px;
        border: none !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .stat-card-new:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    /* Memastikan Ikon tetap proporsional */
    .card-icon { 
        width: 48px; 
        height: 48px; 
        background: rgba(255,255,255,0.2); 
        border-radius: 14px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 20px;
    }

    .chart-card-new canvas{
        max-width:100% !important;
        height:auto !important;
    }

    /* --- FIX ANALYTICS (GRAFIK) --- */
    .dashboard-analytics {
        display: grid;
        grid-template-columns: 2fr 1fr; /* Grafik kiri lebih lebar */
        gap: 25px;
        margin-bottom: 30px;
    }

    /* Saat layar kecil (HP/Tablet), grafik jadi tumpuk atas bawah */
    @media (max-width: 992px) {
        .dashboard-analytics {
            grid-template-columns: 1fr;
        }
    }

    .chart-card-new {
        background: white;
        padding: 30px;
        border-radius: 25px;
        border: 1px solid #e2e8f0;
        min-height: 400px;
        overflow:hidden;
    }

    /* Paksa Modal tampil di atas sidebar dan elemen lainnya */
    .modal {
        z-index: 2050 !important;
    }
    .modal-backdrop {
        z-index: 2040 !important;
    }
    /* Pastikan konten modal tidak terpotong */
    .modal-content {
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 15px 50px rgba(0,0,0,0.3) !important;
    }

    /* --- SMART MOBILE RESPONSIVE (FIXED CENTER) --- */
    @media (max-width: 768px) {
        /* 1. Sidebar: Paksa konten ke tengah secara vertikal & horizontal */
        .sidebar-2026 {
            width: 80px !important;
            left: -80px; 
            transition: 0.3s ease-in-out;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important; /* Kunci Ikon Center */
        }

        /* 2. Munculkan Sidebar melayang */
        .sidebar-2026.show-mobile {
            left: 0 !important;
            width: 80px !important;
            z-index: 2000;
            box-shadow: 10px 0 30px rgba(0,0,0,0.3);
        }

        /* 3. Paksa Nav Link & Header jadi kotak center */
        .sidebar-header, 
        .nav-link, 
        .sidebar-footer, 
        .group-user {
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin: 5px 0 !important; /* Beri jarak antar menu */
            padding: 12px 0 !important;
        }

        /* Buang margin ikon agar tidak berat sebelah */
        .nav-link i {
            margin: 0 !important;
            font-size: 20px !important;
        }

        /* 4. Footer (Profil & Logout) - Kasih jarak biar gak mepet */
        .sidebar-footer {
            padding: 20px 0 !important;
            display:flex !important;
            flex-direction: column !important;
            align-items:center !important;
            gap:15px;
        }

        .group-user{
            flex-direction: column !important;
            align-items: center !important;
            gap:10px;
        }

        .group-user div:first-child{
            margin-right:0 !important;
        }

        .user-avatar {
            margin-right: 0 !important; /* Hilangkan sisa margin desktop */
            width: 40px;
            height: 40px;
        }

        /* Tombol Logout dibuat Kotak Rapi di tengah */
        .btn-logout-custom {
            width: 45px !important;
            height: 45px;
            padding: 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            border-radius: 12px;
        }

        /* 5. Konten Utama Full Layar */
        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
        }

        /* 6. Sembunyikan semua label teks secara mutlak */
        .text-label, 
        .admin-label, 
        h6, 
        .sidebar-header h6,
        .nav-link span {
            display: none !important;
        }
        
        /* 7. Backdrop (Layar Gelap) */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1999;
        }
        .sidebar-overlay.active { display: block; }
    }
    </style>
</head>
<body>

<div class="d-flex">
    {{-- 1. SIDEBAR --}}
    @include('layouts.sidebar')
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    {{-- 2. KONTEN UTAMA --}}
    <main class="main-content">
        
        {{-- NAVBAR --}}
        <nav class="navbar-custom d-flex justify-content-between align-items-center shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <button id="btnToggle" type="button" class="btn rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px;">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark">@yield('page_title', 'Dashboard')</h5>
            </div>
            
            <div class="d-flex align-items-center gap-3">

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle hide-caret" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-none d-sm-block text-end me-2">
                            <div class="fw-bold text-dark small" style="line-height: 1;">{{ auth()->user()->name }}</div>
                            <small class="text-muted text-uppercase" style="font-size: 9px;">{{ auth()->user()->role ?? 'Admin' }}</small>
                        </div>
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;">
                            <i class="fa-solid fa-user-tie text-white"></i>
                        </div>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3" style="border-radius: 15px; min-width: 220px; padding: 8px;">
                        <li><a class="dropdown-item py-2 rounded-3" href="{{ route('profile.edit') }}"><i class="fa-solid fa-id-badge me-3 text-primary"></i>Profil Saya</a></li>
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 rounded-3 text-danger fw-bold">
                                    <i class="fa-solid fa-power-off me-3"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- AREA KONTEN --}}
        <div class="p-4">
            @yield('content')
        </div>
    </main>
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnToggle = document.getElementById('btnToggle');
        const sidebar = document.querySelector('.sidebar-2026');
        const mainContent = document.querySelector('.main-content');
        const overlay = document.getElementById('sidebarOverlay');

        function handleToggle() {
            if (window.innerWidth <= 768) {
                // MODE HP: Munculkan melayang & aktifkan layar gelap
                sidebar.classList.toggle('show-mobile');
                overlay.classList.toggle('active');
            } else {
                // MODE LAPTOP: Perkecil sidebar (Collapsed)
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                const status = sidebar.classList.contains('collapsed') ? 'tertutup' : 'terbuka';
                localStorage.setItem('sidebar_status', status);
            }
        }

        if (btnToggle) btnToggle.addEventListener('click', handleToggle);
        if (overlay) overlay.addEventListener('click', handleToggle);

        // AUTO-HIDE: Sembunyikan sidebar otomatis saat menu diklik (Khusus HP)
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768 && sidebar.classList.contains('show-mobile')) {
                    handleToggle();
                }
            });
        });

        // Cek memori saat refresh (Hanya berlaku untuk Laptop)
        if (window.innerWidth > 768 && localStorage.getItem('sidebar_status') === 'tertutup') {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        }
    });
</script>

@stack('scripts')
</body>
</html>