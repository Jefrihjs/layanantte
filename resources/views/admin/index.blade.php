@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<div class="admin-wrapper">

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

            <a href="{{ route('admin.permohonan.export', ['year' => $year]) }}" class="btn-export">
                Export Excel
            </a>
        </div>
    </div>

    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-title">
                Komposisi Permohonan {{ $year }}
            </div>
        </div>

        <div class="chart-body">
            <canvas id="ttePieChart"></canvas>
        </div>
    </div>

    <div class="stats-grid">

        <a href="{{ route('admin.dashboard', ['year' => $year]) }}"
        class="stat-card total {{ request('jenis') == null ? 'active' : '' }}">

            <div class="stat-header">
                <div>
                    <div class="stat-title">Total {{ $year }}</div>
                    <div class="stat-number">{{ $totalTahun }}</div>
                </div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
            </div>

        </a>

        <a href="{{ route('admin.dashboard', ['year' => $year, 'jenis' => 'baru']) }}"
        class="stat-card baru {{ request('jenis') == 'baru' ? 'active' : '' }}">

            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Pendaftaran Baru</div>
                    <div class="stat-number">{{ $totalBaru }}</div>
                </div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="17" y1="11" x2="23" y2="11"></line></svg>
                </div>
            </div>

        </a>

        <a href="{{ route('admin.dashboard', ['year' => $year, 'jenis' => 'reset_passphrase']) }}"
        class="stat-card reset {{ request('jenis') == 'reset_passphrase' ? 'active' : '' }}">

            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Reset</div>
                    <div class="stat-number">{{ $totalReset }}</div>
                </div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 4v6h-6"></path><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                </div>
            </div>

        </a>

        <a href="{{ route('admin.dashboard', ['year' => $year, 'jenis' => 'perpanjangan']) }}"
        class="stat-card perpanjangan {{ request('jenis') == 'perpanjangan' ? 'active' : '' }}">

            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Perpanjangan</div>
                    <div class="stat-number">{{ $totalPerpanjangan }}</div>
                </div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
            </div>

        </a>

    </div>

    <div class="table-card">
    <div class="table-header-flex">
        <div class="header-left">
            <h3 class="table-main-title">Tabel Data Permohonan TTE</h3>
            <div class="header-divider"></div>
            <div class="active-badge-zone">
                @if(request('jenis') == 'baru')
                    <span class="filter-badge biru">Pendaftaran Baru</span>
                @elseif(request('jenis') == 'reset_passphrase')
                    <span class="filter-badge orange">Reset Passphrase</span>
                @elseif(request('jenis') == 'perpanjangan')
                    <span class="filter-badge hijau">Perpanjangan Sertifikat</span>
                @else
                    <span class="filter-badge abu">Semua Jenis</span>
                @endif
            </div>
        </div>

        <div class="header-right">
            <form method="GET" class="filter-form">
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                
                <select name="triwulan" class="select-triwulan-inline" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="1" {{ request('triwulan') == 1 ? 'selected' : '' }}>Triwulan 1</option>
                    <option value="2" {{ request('triwulan') == 2 ? 'selected' : '' }}>Triwulan 2</option>
                    <option value="3" {{ request('triwulan') == 3 ? 'selected' : '' }}>Triwulan 3</option>
                    <option value="4" {{ request('triwulan') == 4 ? 'selected' : '' }}>Triwulan 4</option>
                </select>
            </form>
        </div>
    </div>

    <div class="table-wrapper">
    <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Unit Kerja</th>
                    <th>Jenis</th>
                    <th>Diproses Oleh</th>
                    <th>Aksi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $i => $log)
                <tr>
                    <td>{{ $logs->firstItem() + $i }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $log->nama }}</td>
                    <td>{{ $log->nik }}</td>
                    <td>{{ $log->unit_kerja }}</td>

                    <td>
                        @if($log->jenis_permohonan == 'reset_passphrase')
                            <span class="badge reset">Reset Passphrase</span>
                        @elseif($log->jenis_permohonan == 'perpanjangan')
                            <span class="badge perpanjangan">Perpanjangan Sertifikat</span>
                        @elseif($log->jenis_permohonan == 'baru')
                            <span class="badge baru">Pendaftaran Baru</span>
                        @endif
                    </td>

                    <td>{{ $log->admin->name ?? '-' }}</td>

                    <td>
                        <button 
                            type="button"
                            class="btn-view"
                            onclick="openModal('{{ route('admin.permohonan.show', $log->id) }}')">
                            Lihat
                        </button>
                    </td>

                    <td>{{ $log->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        <div class="pagination">
            {{ $logs->links() }}
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

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Pendaftaran Baru', 'Reset Passphrase', 'Perpanjangan'],
        datasets: [{
            data: [
                {{ $totalBaru }},
                {{ $totalReset }},
                {{ $totalPerpanjangan }}
            ],
            backgroundColor: [
                '#2563eb',
                '#f59e0b',
                '#16a34a'
            ],
            borderWidth: 0
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12
                }
            }
        }
    }
});
</script>

@endsection
