@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<div class="admin-wrapper">
{{-- ===================== NOTIFIKASI START ===================== --}}
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('import_errors'))
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <strong>Gagal Import!</strong> Periksa data berikut:
            <ul style="margin-top: 10px; margin-left: 20px;">
                @foreach(session('import_errors') as $failure)
                    <li>Baris ke-{{ $failure->row() }}: {{ $failure->errors()[0] }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- ===================== NOTIFIKASI END ===================== --}}
    <div class="page-header">
        <div>
            <div class="page-title">Dashboard Permohonan TTE</div>
            <div class="page-sub">
                Monitoring permohonan tahun {{ $year }}
            </div>
        </div>

        <div class="page-actions">

            <form method="GET">
                <select name="year" class="select-year" onchange="this.form.submit()">
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </form>

            <a href="{{ route('admin.permohonan.export', ['year' => $year]) }}"
            class="btn-primary">
                Export Excel
            </a>

           <button type="button" class="btn-primary" onclick="openImportModal()">
                Import Excel
            </button>

        </div>
    </div>

    <div class="stats-grid-new">

        <a href="{{ route('admin.permohonan.index') }}" class="stat-card-new">
            <span>Total Permohonan</span>
            <h3>{{ $totalTahun }}</h3>
        </a>

        <a href="{{ route('admin.permohonan.index', ['status' => 'pending']) }}" class="stat-card-new">
            <span>Pending</span>
            <h3>{{ $totalPending }}</h3>
        </a>

        <a href="{{ route('admin.permohonan.index', ['status' => 'diproses']) }}" class="stat-card-new">
            <span>Diproses</span>
            <h3>{{ $totalDiproses }}</h3>
        </a>

        <div class="stat-card-new">
            <span>Tingkat Penyelesaian</span>
            <h3>{{ $rasio }}%</h3>
        </div>

    </div> <!-- ✅ TUTUP GRID CARD DI SINI -->


    <div class="dashboard-analytics">

        <div class="chart-card-new">
            <h4>Status Permohonan</h4>
            <canvas id="statusChart"></canvas>
        </div>

        <div class="chart-card-new">
            <h4>Distribusi Jenis Permohonan</h4>
            <canvas id="jenisChart"></canvas>
        </div>

    </div>

</div>

{{-- ===================== MODAL ===================== --}}
<div id="detailModal" class="modal-overlay" style="display:none;">
    <div class="modal-box large">
        <div class="modal-header">
            <h3>Detail Permohonan</h3>
            <button onclick="closeModal()" class="modal-close">
                <svg viewBox="0 0 24 24" width="18" height="18">
                    <path d="M6 6L18 18M6 18L18 6"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"/>
                </svg>
            </button>
        </div>

        <div class="modal-body" id="modalContent">
            Loading...
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function openModal(url) {

    document.getElementById('detailModal').style.display = 'flex';
    document.getElementById('modalContent').innerHTML = 'Loading...';

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('modalContent').innerHTML = html;
    });
}

function closeModal() {
    document.getElementById('detailModal').style.display = 'none';
}

document.getElementById('detailModal').addEventListener('click', function(e){
    if(e.target === this){
        closeModal();
    }
});
</script>
<script>
const ctx = document.getElementById('ttePieChart');

new Chart(document.getElementById('statusChart'), {
    type: 'bar',
    data: {
        labels: ['Pending','Diproses'],
        datasets: [{
            data: [{{ $totalPending }}, {{ $totalDiproses }}]
        }]
    }
});

new Chart(document.getElementById('jenisChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pendaftaran Baru','Reset Passphrase','Perpanjangan'],
        datasets: [{
            data: [
                {{ $totalBaru }},
                {{ $totalReset }},
                {{ $totalPerpanjangan }}
            ]
        }]
    }
});
</script>
<div id="importModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Import Data Excel</h3>
            <button onclick="closeImportModal()" class="modal-close">&times;</button>
        </div>

        <form action="{{ route('admin.import') }}"
              method="POST"
              enctype="multipart/form-data"
              class="modal-body">
            @csrf

            <input type="file" name="file" required class="file-input">

            <button type="submit" class="btn-primary" style="margin-top:15px;">
                Upload & Import
            </button>
        </form>
    </div>
</div>

<script>
function openImportModal() {
    document.getElementById('importModal').classList.add('active');
}

function closeImportModal() {
    document.getElementById('importModal').classList.remove('active');
}

document.getElementById('importModal').addEventListener('click', function(e){
    if(e.target === this){
        closeImportModal();
    }
});
</script>

@endsection
