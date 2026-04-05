@extends('layouts.app')

{{-- Topbar akan otomatis mengambil ini sebagai judul di atas --}}
@section('page_title', 'Dashboard Monitoring') 

@section('content')
<div class="dashboard-container">

    {{-- 1. KOTAK STATISTIK (4 KOLOM) --}}
    <div class="stats-grid-new">
    
    <a href="{{ route('permohonan.index', ['tahun' => $tahun]) }}" 
       class="stat-card-new shadow-lg border-0 relative overflow-hidden" 
       style="background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); color: white !important; padding: 2rem 1.5rem !important;">
        <div class="card-top">
            <div class="card-icon" style="background: rgba(255,255,255,0.15); color: white; width: 45px; height: 45px; border-radius: 12px;">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div class="card-title text-white opacity-80" style="font-size: 13px;">Total Permohonan</div>
        </div>
        <div class="card-number text-white" style="font-size: 32px; margin-top: 10px;">{{ $total }}</div>
        <div class="card-sub text-white opacity-50">Tahun {{ $tahun }}</div>
        {{-- Ornamen Lingkaran Halus --}}
        <div style="position: absolute; bottom: -20px; right: -20px; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    </a>

    <a href="{{ route('permohonan.index', ['status' => 'pending', 'tahun' => $tahun]) }}" 
       class="stat-card-new shadow-lg border-0 relative overflow-hidden"
       style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%); color: white !important; padding: 2rem 1.5rem !important;">
        <div class="card-top">
            <div class="card-icon" style="background: rgba(255,255,255,0.15); color: white; width: 45px; height: 45px; border-radius: 12px;">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="card-title text-white opacity-80" style="font-size: 13px;">Pending</div>
        </div>
        <div class="card-number text-white" style="font-size: 32px; margin-top: 10px;">{{ $pending }}</div>
        <div class="card-sub text-white opacity-50">Menunggu Verifikasi</div>
        <div style="position: absolute; bottom: -20px; right: -20px; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    </a>

    <a href="{{ route('permohonan.index', ['status' => 'diproses', 'tahun' => $tahun]) }}" 
       class="stat-card-new shadow-lg border-0 relative overflow-hidden"
       style="background: linear-gradient(135deg, #115e59 0%, #0d9488 50%, #d97706 100%); color: white !important; padding: 2rem 1.5rem !important;">
        <div class="card-top">
            <div class="card-icon" style="background: rgba(255,255,255,0.15); color: white; width: 45px; height: 45px; border-radius: 12px;">
                <i class="fa-solid fa-spinner fa-spin-hover"></i>
            </div>
            <div class="card-title text-white opacity-80" style="font-size: 13px;">Diproses</div>
        </div>
        <div class="card-number text-white" style="font-size: 32px; margin-top: 10px;">{{ $diproses }}</div>
        <div class="card-sub text-white opacity-50">Sedang Berjalan</div>
        <div style="position: absolute; bottom: -20px; right: -20px; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    </a>

    <div class="stat-card-new shadow-lg border-0 relative overflow-hidden"
         style="background: linear-gradient(135deg, #0f766e 0%, #d97706 100%); color: white !important; padding: 2rem 1.5rem !important;">
        <div class="card-top">
            <div class="card-icon" style="background: rgba(255,255,255,0.15); color: white; width: 45px; height: 45px; border-radius: 12px;">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div class="card-title text-white opacity-80" style="font-size: 13px;">Penyelesaian</div>
        </div>
        <div class="card-number text-white" style="font-size: 32px; margin-top: 10px;">{{ $persenSelesai }}%</div>
        <div class="card-sub text-white opacity-50">Completion Rate</div>
        <div style="position: absolute; bottom: -20px; right: -20px; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    </div>

</div>

    {{-- 2. GRAFIK ANALITIK --}}
    <div class="dashboard-analytics">
        <div class="chart-card-new">
            <div class="chart-header-flex d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Status Permohonan</h4>
                
                {{-- Dropdown Tahun Pindah ke Sini agar Bersih --}}
                <div class="d-flex gap-2 align-items-center">
                    <form method="GET" class="m-0">
                        <select name="tahun" onchange="this.form.submit()" class="form-select form-select-sm w-auto">
                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </form>
                    <div class="chart-toggle d-flex">
                        <button type="button" id="btnBar" class="btn btn-sm btn-outline-primary active">Bar</button>
                        <button type="button" id="btnPie" class="btn btn-sm btn-outline-primary ms-1">Pie</button>
                    </div>
                </div>
            </div>
            
            <div class="chart-wrapper" style="height: 300px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="chart-card-new">
            <h4 class="mb-4">Distribusi Jenis</h4>
            <div class="chart-wrapper" style="height: 300px;">
                <canvas id="jenisChart"></canvas>
            </div>
        </div>
    </div>

    {{-- 3. TABEL TERBARU --}}
    <div class="recent-card border-0 shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Permohonan Terbaru</h4>
            <a href="{{ route('permohonan.index') }}" class="btn btn-primary btn-sm px-3">
                Lihat Semua Data
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latest as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->nama }}</td>
                        <td class="text-capitalize small">{{ str_replace('_', ' ', $item->jenis_permohonan) }}</td>
                        <td>
                            <span class="badge {{ $item->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }} px-3">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const statusData = {
        labels: ['Pending','Diproses'],
        datasets: [{
            data: [{{ $pending }}, {{ $diproses }}],
            backgroundColor: ['#f59e0b', '#16a34a'],
            borderWidth: 0
        }]
    };

    const ctxStatus = document.getElementById('statusChart');
    let statusChart = new Chart(ctxStatus, {
        type: 'bar',
        data: statusData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Toggle Bar/Pie
    document.getElementById('btnBar').addEventListener('click', function() {
        statusChart.destroy();
        statusChart = new Chart(ctxStatus, { type: 'bar', data: statusData, options: { responsive: true, maintainAspectRatio: false } });
        updateBtn(this);
    });

    document.getElementById('btnPie').addEventListener('click', function() {
        statusChart.destroy();
        statusChart = new Chart(ctxStatus, { type: 'pie', data: statusData, options: { responsive: true, maintainAspectRatio: true } });
        updateBtn(this);
    });

    function updateBtn(btn) {
        document.querySelectorAll('.chart-toggle button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    // Donut Jenis
    new Chart(document.getElementById('jenisChart'), {
        type: 'doughnut',
        data: {
            labels: ['Baru', 'Reset', 'Perpanjangan'],
            datasets: [{
                data: [{{ $pendaftaran }}, {{ $reset }}, {{ $perpanjangan }}],
                backgroundColor: ['#3b82f6', '#fbbf24', '#34d399'],
                borderWidth: 0,
                // Efek melayang: potongan akan keluar sejauh 15px saat di-hover
                hoverOffset: 20, 
                // Menambah jarak antar potongan (opsional, biar lebih elegan)
                spacing: 5 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%', // Diperlebar sedikit lubang tengahnya biar lebih modern
            layout: {
                padding: 20 // Beri ruang agar saat melayang tidak terpotong garis canvas
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true, // Ikon bulat di legend
                        padding: 20
                    }
                },
                tooltip: {
                    // Tooltip lebih cantik
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: true
                }
            },
            // Efek transisi saat hover diperhalus
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
});
</script>
@endsection