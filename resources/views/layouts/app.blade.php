<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikator TTE</title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>

<body>

    {{-- HEADER --}}
    <div class="admin-header">

        <div class="header-left">
            <img src="{{ asset('img/logo-beltim.png') }}" class="header-logo">
            <span class="header-title">Verifikator TTE</span>
        </div>

        {{-- TOGGLE BUTTON (MOBILE ONLY) --}}
        <button class="nav-toggle" id="navToggleBtn">
            ☰
        </button>
         
        {{-- NAV MENU --}}
        <nav class="admin-nav">
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('permohonan.index') }}"
                class="{{ request()->routeIs('permohonan.*') ? 'nav-active' : '' }}">
                Data Permohonan
            </a>
        </nav>

        <div class="header-right">
            <div class="admin-info">
                <div class="admin-avatar-text">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span>{{ auth()->user()->name }}</span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-icon" title="Logout">
                    Logout
                </button>
            </form>
        </div>

    </div>

    {{-- GLOBAL MODAL --}}
    <div id="detailModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detail Permohonan</h3>
                <button onclick="closeModal()">×</button>
            </div>
            <div id="modalBody">
                Loading...
            </div>
        </div>
    </div>


    {{-- CONTENT --}}
    <div class="content-wrapper">
        @yield('content')
    </div>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        const navBtn = document.getElementById('navToggleBtn');
        const navMenu = document.querySelector('.admin-nav')

        if (navBtn && navMenu) {
            navBtn.addEventListener('click', function () {
                navMenu.classList.toggle('active');
            });
        }

    });
    </script>
</body>
</html>
