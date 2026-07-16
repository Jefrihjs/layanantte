@extends('layouts.app')

@section('page_title', 'Dashboard Monitoring')

@section('content')
<div style="width: 100%; clear: both;">

    {{-- 1. TITLE AREA --}}
    <div style="margin-bottom: 30px;">
        <h3 style="font-weight: 800; color: #1e293b; margin: 0 0 5px 0;">Ringkasan Data TTE</h3>
        <p style="color: #64748b; margin: 0; font-size: 14px;">
            Monitoring data permohonan dan laporan kendala pada periode tahun <strong>{{ $tahun }}</strong>.
        </p>
    </div>

    {{-- 2. KOTAK STATISTIK (5 KARTU) --}}
    <div style="display: flex !important; flex-direction: row !important; margin: 0 -10px 30px -10px; width: 100%;">
        
        <div style="width: 20%; padding: 0 10px;">
            <div onclick="window.location.href='{{ route('permohonan.index') }}'" style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                    <div style="width: 40px; height: 40px; background: #f1f5f9; color: #0f172a; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b;">Total Permohonan</span>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #1e293b; margin-bottom: 5px;">{{ $total }}</div>
                <div style="font-size: 11px; color: #94a3b8; font-weight: 600;">Data Tahun {{ $tahun }}</div>
            </div>
        </div>

        <div style="width: 20%; padding: 0 10px;">
            <div onclick="window.location.href='{{ route('permohonan.index', ['jenis' => 'lapor_kendala']) }}'" style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                    <div style="width: 40px; height: 40px; background: #fef2f2; color: #dc2626; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-bug"></i>
                    </div>
                    <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b;">Lapor Kendala</span>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #dc2626; margin-bottom: 5px;">{{ $totalKendala }}</div>
                <div style="font-size: 11px; color: #dc2626; font-weight: 700;">{{ $kendalaPending }} Laporan Menunggu</div>
            </div>
        </div>

        <div style="width: 20%; padding: 0 10px;">
            <div onclick="window.location.href='{{ route('permohonan.index') }}'" style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
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

        <div style="width: 20%; padding: 0 10px;">
            <div onclick="window.location.href='{{ route('permohonan.index') }}'" style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
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

        <div style="width: 20%; padding: 0 10px;">
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
                <h5 style="font-weight: 800; color: #1e293b; margin: 0;">Statistik Permohonan vs Kendala</h5>
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
            <h5 style="font-weight: 800; color: #1e293b; margin-bottom: 25px;">Aktivitas Terbaru</h5>
            <div style="font-size: 13px;">
                @forelse($latest as $item)
                {{-- UBAH MENJADI ONCLICK UNTUK BUKA MODAL --}}
                <div onclick="showDetail('{{ route('permohonan.detail', $item->id) }}')" style="cursor: pointer; padding: 12px 0; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 150px;">
                        <span style="font-weight: 700; color: #334155;">{{ $item->nama }}</span>
                        @if($item->jenis_permohonan == 'lapor_kendala')
                            <i class="fa-solid fa-bug text-red-500 text-xs ml-1" title="Lapor Kendala"></i>
                        @endif
                    </div>
                    <span style="background: {{ $item->jenis_permohonan == 'lapor_kendala' ? '#fef2f2' : '#f1f5f9' }}; color: {{ $item->jenis_permohonan == 'lapor_kendala' ? '#dc2626' : '#475569' }}; padding: 4px 10px; border-radius: 50px; font-size: 10px; font-weight: 700;">{{ ucfirst($item->status) }}</span>
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

{{-- TAMBAHAN: MODAL DETIL (SAMA PERSIS SEPERTI DI HALAMAN INDEX) --}}
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4" style="background: #0f766e; color: white;">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-lines me-2"></i> Detail Permohonan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="detailContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Mengambil data...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('statusChart');
        if (ctx) {
            // Ambil data dari Controller
            const chartData = @json($chartData);
            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            
            const pendingData = chartData.map(d => d.pending);
            const diprosesData = chartData.map(d => d.diproses);

            new Chart(ctx, {
                type: 'bar', // Bisa diubah ke 'line' jika ingin grafik garis
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Permohonan Pending',
                            data: pendingData,
                            backgroundColor: '#f59e0b',
                            borderRadius: 8,
                            stack: 'Stack 0',
                        },
                        {
                            label: 'Permohonan Diproses',
                            data: diprosesData,
                            backgroundColor: '#10b981',
                            borderRadius: 8,
                            stack: 'Stack 0',
                        },
                        {
                            label: 'Lapor Kendala',
                            data: [{{ $kendalaPending ?? 0 }}, {{ $kendalaDiproses ?? 0 }}], // Ini hanya contoh jika ingin dipisah, bisa disesuaikan
                            backgroundColor: '#dc2626',
                            borderRadius: 8,
                            hidden: true // Sembunyikan agar tidak mengganggu grafik utama
                        }
                    ]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { 
                        legend: { 
                            display: true,
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 11
                                }
                            }
                        } 
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: '#f1f5f9' }, 
                            border: { display: false },
                            ticks: {
                                stepSize: 1, // Biar angka grafik bilangan bulat (1, 2, 3) bukan desimal (0.1, 0.2)
                            }
                        },
                        x: { 
                            grid: { display: false }, 
                            border: { display: false } 
                        }
                    }
                }
            });
        }

        // FUNGSI AJAX UNTUK MEMBUKA MODAL DETAIL
        window.showDetail = function(url) {
            const myModal = new bootstrap.Modal(document.getElementById('modalDetail'));
            myModal.show();

            document.getElementById('detailContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-teal" role="status" style="color: #0f766e;"></div>
                    <p class="mt-2 text-muted small fw-bold">MEMUAT DATA...</p>
                </div>
            `;

            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('detailContent').innerHTML = html;
                })
                .catch(error => {
                    document.getElementById('detailContent').innerHTML = `
                        <div class="alert alert-danger m-3">Gagal mengambil data. Silakan coba lagi.</div>
                    `;
                });
        };
    });
</script>
@endpush
@endsection