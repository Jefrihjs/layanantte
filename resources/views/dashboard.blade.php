@extends('layouts.app')

@section('page_title', 'Dashboard Monitoring')

@section('content')
<div style="width: 100%; clear: both;">

    {{-- 1. TITLE AREA - BERSIH TANPA BACKGROUND --}}
    <div style="margin-bottom: 30px;">
        <h3 style="font-weight: 800; color: #1e293b; margin: 0 0 5px 0;">Ringkasan Data TTE</h3>
        <p style="color: #64748b; margin: 0; font-size: 14px;">
            Monitoring data permohonan aktif pada periode tahun <strong>{{ $tahun }}</strong>.
        </p>
    </div>

    {{-- 2. KOTAK STATISTIK - PUTIH BERSIH (PASTI SEJAJAR) --}}
    <div style="display: flex !important; flex-direction: row !important; margin: 0 -10px 30px -10px; width: 100%;">
        
        <div style="width: 25%; padding: 0 10px;">
            <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                    <div style="width: 40px; height: 40px; background: #f1f5f9; color: #0f172a; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b;">Total Masuk</span>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #1e293b; margin-bottom: 5px;">{{ $total }}</div>
                <div style="font-size: 11px; color: #94a3b8; font-weight: 600;">Data Tahun {{ $tahun }}</div>
            </div>
        </div>

        <div style="width: 25%; padding: 0 10px;">
            <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                    <div style="width: 40px; height: 40px; background: #fff7ed; color: #d97706; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-hourglass-start"></i>
                    </div>
                    <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b;">Pending</span>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #1e293b; margin-bottom: 5px;">{{ $pending }}</div>
                <div style="font-size: 11px; color: #d97706; font-weight: 700;">Menunggu Verifikasi</div>
            </div>
        </div>

        <div style="width: 25%; padding: 0 10px;">
            <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                    <div style="width: 40px; height: 40px; background: #f0fdf4; color: #16a34a; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-spinner"></i>
                    </div>
                    <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b;">Diproses</span>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #1e293b; margin-bottom: 5px;">{{ $diproses }}</div>
                <div style="font-size: 11px; color: #16a34a; font-weight: 700;">Dalam Pengerjaan</div>
            </div>
        </div>

        <div style="width: 25%; padding: 0 10px;">
            <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                    <div style="width: 40px; height: 40px; background: #eff6ff; color: #2563eb; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-square-check"></i>
                    </div>
                    <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b;">Penyelesaian</span>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #1e293b; margin-bottom: 5px;">{{ $persenSelesai }}%</div>
                <div style="font-size: 11px; color: #2563eb; font-weight: 700;">Completion Rate</div>
            </div>
        </div>

    </div>

    {{-- 3. GRAFIK & TABEL --}}
    <div style="display: flex; gap: 20px;">
        <div style="width: 65%; background: white; padding: 30px; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h5 style="font-weight: 800; color: #1e293b; margin: 0;">Statistik Permohonan</h5>
                <form method="GET">
                    <select name="tahun" onchange="this.form.submit()" style="padding: 5px 15px; border-radius: 50px; border: 1px solid #e2e8f0; font-size: 12px; font-weight: 600; cursor: pointer;">
                        @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>Tahun {{ $i }}</option>
                        @endfor
                    </select>
                </form>
            </div>
            <div style="height: 300px;"><canvas id="statusChart"></canvas></div>
        </div>

        <div style="width: 35%; background: white; padding: 30px; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <h5 style="font-weight: 800; color: #1e293b; margin-bottom: 25px;">Permohonan Terbaru</h5>
            <div style="font-size: 13px;">
                @forelse($latest as $item)
                <div style="padding: 12px 0; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 150px;">
                        <span style="font-weight: 700; color: #334155;">{{ $item->nama }}</span>
                    </div>
                    <span style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 50px; font-size: 10px; font-weight: 700;">{{ $item->status }}</span>
                </div>
                @empty
                <p style="text-align: center; color: #94a3b8; font-style: italic;">Belum ada data.</p>
                @endforelse
            </div>
            <div style="margin-top: 20px; text-align: center;">
                <a href="{{ route('permohonan.index') }}" style="font-size: 12px; font-weight: 700; color: #2563eb; text-decoration: none;">Lihat Semua Data →</a>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: ['Pending', 'Diproses'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $pending }}, {{ $diproses }}],
                    backgroundColor: ['#f59e0b', '#10b981'],
                    borderRadius: 12,
                    barThickness: 50
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                }
            }
        });
    });
</script>
@endpush
@endsection