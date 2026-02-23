@extends('layouts.app')

@section('content')

<div class="page-container">

    <div class="page-header-flex">

        <div>
            <h2>Data Permohonan</h2>
            <span class="page-subtitle">
                Menampilkan {{ $data->total() }} data
            </span>
        </div>

        <div>
            <a href="{{ route('permohonan.export', request()->query()) }}"
            class="btn-export">
                Export Excel
            </a>
        </div>

    </div>


    {{-- FILTER --}}
    <form method="GET" class="page-filter">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari NIK atau Nama">

        <select name="tahun">
            <option value="">Semua Tahun</option>
            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>

        <select name="triwulan">
            <option value="">Semua Triwulan</option>
            <option value="1" {{ request('triwulan') == 1 ? 'selected' : '' }}>Triwulan 1</option>
            <option value="2" {{ request('triwulan') == 2 ? 'selected' : '' }}>Triwulan 2</option>
            <option value="3" {{ request('triwulan') == 3 ? 'selected' : '' }}>Triwulan 3</option>
            <option value="4" {{ request('triwulan') == 4 ? 'selected' : '' }}>Triwulan 4</option>
        </select>

        <select name="jenis">
            <option value="">Semua Jenis</option>
            <option value="baru" {{ request('jenis') == 'baru' ? 'selected' : '' }}>Pendaftaran Baru</option>
            <option value="reset_passphrase" {{ request('jenis') == 'reset_passphrase' ? 'selected' : '' }}>Reset Passphrase</option>
            <option value="perpanjangan" {{ request('jenis') == 'perpanjangan' ? 'selected' : '' }}>Perpanjangan</option>
        </select>

        <button type="submit">Filter</button>
    </form>

    {{-- TABLE --}}
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>{{ $item->tanggal->format('d-m-Y H:i') }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>
                            @if($item->jenis_permohonan == 'baru')
                                Pendaftaran Baru
                            @elseif($item->jenis_permohonan == 'reset_passphrase')
                                Reset Passphrase
                            @else
                                Perpanjangan
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $item->status == 'diproses' ? 'badge-success' : 'badge-warning' }}">
                                {{ $item->status ?? 'pending' }}
                            </span>
                        </td>
                        <td style="display:flex; gap:10px; align-items:center;">

                            {{-- Detail --}}
                            <a href="javascript:void(0)"
                                class="btn-detail"
                                title="Detail"
                                onclick="showDetail('{{ route('permohonan.detail', ':id') }}'.replace(':id', {{ $item->id }}))">

                                <!-- Icon Eye -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="18"
                                    height="18"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('permohonan.destroy', $item->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn-icon-delete"
                                        title="Hapus">

                                    <!-- Icon Trash -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14H6L5 6"/>
                                        <path d="M10 11v6"/>
                                        <path d="M14 11v6"/>
                                        <path d="M9 6V4h6v2"/>
                                    </svg>
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        <div class="pagination-center">
            {{ $data->appends(request()->query())->links() }}
        </div>
    </div>


</div>

<script>
function showDetail(url) {
    const modal = document.getElementById('detailModal');
    const body = document.getElementById('modalBody');

    modal.classList.add('show');
    body.innerHTML = 'Loading...';

    fetch(url)
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
        });
}

function closeModal() {
    document.getElementById('detailModal').classList.remove('show');
}
</script>

@endsection
