@extends('layouts.app')

@section('content')

<div class="dashboard-container">

    <div class="dashboard-header">

    <div class="header-left">
        <h2>Dashboard Monitoring</h2>
        <p class="header-sub">
            <strong>{{ $total }}</strong> permohonan pada tahun {{ $tahun }},
            didominasi oleh 
            <strong>
                @if($pendaftaran >= $reset && $pendaftaran >= $perpanjangan)
                    Pendaftaran Baru
                @elseif($reset >= $perpanjangan)
                    Reset Passphrase
                @else
                    Perpanjangan
                @endif
            </strong>.
        </p>
    </div>

    <form method="GET" class="header-filter">
        <select name="tahun" onchange="this.form.submit()">
            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>
    </form>

</div>


<div class="stats-grid-new">

    <a href="{{ route('permohonan.index', ['tahun' => $tahun]) }}" 
       class="stat-card-new total">

        <div class="card-top">
            <div class="card-icon total-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="4"/>
                    <line x1="8" y1="15" x2="8" y2="11"/>
                    <line x1="12" y1="15" x2="12" y2="7"/>
                    <line x1="16" y1="15" x2="16" y2="9"/>
                </svg>
            </div>
            <div class="card-title">Total Permohonan</div>
        </div>

        <div class="card-number">{{ $total }}</div>
        <div class="card-sub">Total Permohonan</div>

    </a>


    <a href="{{ route('permohonan.index', ['status' => 'pending', 'tahun' => $tahun]) }}" 
       class="stat-card-new pending">

        <div class="card-top">
            <div class="card-icon pending-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
            </div>
            <div class="card-title">Pending</div>
        </div>

        <div class="card-number">{{ $pending }}</div>
        <div class="card-sub">Pending</div>

    </a>


    <a href="{{ route('permohonan.index', ['status' => 'diproses', 'tahun' => $tahun]) }}" 
       class="stat-card-new diproses">

        <div class="card-top">
            <div class="card-icon diproses-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div class="card-title">Diproses</div>
        </div>

        <div class="card-number">{{ $diproses }}</div>
        <div class="card-sub">Diproses</div>

    </a>


    <div class="stat-card-new selesai">

        <div class="card-top">
            <div class="card-icon selesai-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 17l6-6 4 4 7-7"/>
                    <polyline points="14 4 21 4 21 11"/>
                </svg>
            </div>
            <div class="card-title">Tingkat Penyelesaian</div>
        </div>

        <div class="card-number">{{ $persenSelesai }}%</div>
        <div class="card-sub">Completion Rate</div>

    </div>

</div>

<div class="dashboard-analytics">

    <div class="chart-card-new">

        <div class="chart-header-flex">
            <h4>Status Permohonan</h4>

            <div class="chart-toggle">
                <button type="button" id="btnBar" class="active">Bar</button>
                <button type="button" id="btnPie">Pie</button>
            </div>
        </div>
        
       <div class="chart-wrapper">
            <canvas id="statusChart"></canvas>
        </div>

    </div>

    <div class="chart-card-new">
        <h4>Distribusi Jenis Permohonan</h4>
        <div class="chart-wrapper">
            <canvas id="jenisChart"></canvas>
        </div>
    </div>

</div>

<div class="recent-card">
    <h4>Permohonan Terbaru</h4>
    <div class="table-responsive">
    <table>
        <thead>
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
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jenis_permohonan }}</td>
                <td>
                    @if($item->status == 'pending')
                        <span class="badge-status pending">Pending</span>
                    @elseif($item->status == 'diproses')
                        <span class="badge-status diproses">Diproses</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div style="text-align:right; margin-top:15px;">
        <a href="{{ route('permohonan.index') }}" class="btn-primary">
            Lihat Semua Data
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {

    /* ================= CENTER TEXT PLUGIN (DONUT) ================= */
    const centerText = {
        id: 'centerText',
        afterDraw(chart) {
            const { ctx, chartArea } = chart;
            if (!chartArea) return;

            ctx.save();
            ctx.font = 'bold 26px sans-serif';
            ctx.fillStyle = '#111827';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            ctx.fillText(
                {{ $total }},
                (chartArea.left + chartArea.right) / 2,
                (chartArea.top + chartArea.bottom) / 2
            );

            ctx.restore();
        }
    };

    /* ================= STATUS CHART (BAR / PIE TOGGLE) ================= */

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
            plugins: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    document.getElementById('btnBar').addEventListener('click', function() {
        statusChart.destroy();
        statusChart = new Chart(ctxStatus, {
            type: 'bar',
            data: statusData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                y: { beginAtZero: true }
                }
            }
        });
        setActive(this);
    });

    document.getElementById('btnPie').addEventListener('click', function() {
        statusChart.destroy();
        statusChart = new Chart(ctxStatus, {
            type: 'pie',
            data: statusData,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
        setActive(this);
    });

    function setActive(button) {
        document.querySelectorAll('.chart-toggle button')
            .forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
    }

    /* ================= DONUT JENIS ================= */

    new Chart(document.getElementById('jenisChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pendaftaran Baru','Reset Passphrase','Perpanjangan'],
            datasets: [{
                data: [
                    {{ $pendaftaran }},
                    {{ $reset }},
                    {{ $perpanjangan }}
                ],
                backgroundColor: [
                    '#3b82f6',  // biru soft
                    '#fbbf24',  // kuning soft
                    '#34d399'   // hijau soft
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            radius: '65%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        generateLabels(chart) {
                            const data = chart.data.datasets[0].data;
                            const total = data.reduce((a,b)=>a+b,0);

                            return chart.data.labels.map((label, i) => {
                                const value = data[i];
                                const percent = total > 0 ? Math.round((value/total)*100) : 0;

                                return {
                                    text: label + '  ' + percent + '%',
                                    fillStyle: chart.data.datasets[0].backgroundColor[i],
                                    strokeStyle: chart.data.datasets[0].backgroundColor[i],
                                    lineWidth: 0,
                                    hidden: false,
                                    index: i
                                };
                            });
                        }
                    }
                }
            }
        },
        plugins: [{
            id: 'centerPercent',
            afterDraw(chart) {
                const { ctx, chartArea } = chart;
                if (!chartArea) return;

                const data = chart.data.datasets[0].data;
                const total = data.reduce((a,b)=>a+b,0);
                const maxValue = Math.max(...data);
                const percent = total > 0 ? Math.round((maxValue/total)*100) : 0;

                ctx.save();
                ctx.font = 'bold 28px sans-serif';
                ctx.fillStyle = '#111827';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(
                    percent + '%',
                    (chartArea.left + chartArea.right)/2,
                    (chartArea.top + chartArea.bottom)/2
                );
                ctx.restore();
            }
        }]
    });
});
</script>

@endsection
