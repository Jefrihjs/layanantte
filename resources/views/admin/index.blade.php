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


    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">Total {{ $year }}</div>
            <div class="stat-number">{{ $totalTahun }}</div>
        </div>

        <div class="stat-card baru">
            <div class="stat-title">Total Pendaftaran Baru</div>
            <div class="stat-number">{{ $totalBaru }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Total Reset</div>
            <div class="stat-number">{{ $totalReset }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Total Perpanjangan</div>
            <div class="stat-number">{{ $totalPerpanjangan }}</div>
        </div>
    </div>


<div class="table-card">

<div class="table-header">
    <form method="GET">
        <input type="hidden" name="year" value="{{ $year }}">

        <select name="triwulan" class="select-year" onchange="this.form.submit()">
            <option value="">Semua</option>
            <option value="1" {{ request('triwulan') == 1 ? 'selected' : '' }}>Triwulan 1</option>
            <option value="2" {{ request('triwulan') == 2 ? 'selected' : '' }}>Triwulan 2</option>
            <option value="3" {{ request('triwulan') == 3 ? 'selected' : '' }}>Triwulan 3</option>
            <option value="4" {{ request('triwulan') == 4 ? 'selected' : '' }}>Triwulan 4</option>
        </select>
    </form>
</div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
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
                    <td>
                        @if($log->jenis_permohonan == 'reset_passphrase')
                            <span class="badge reset">Reset</span>
                        @elseif($log->jenis_permohonan == 'perpanjangan')
                            <span class="badge perpanjangan">Perpanjangan</span>
                        @elseif($log->jenis_permohonan == 'baru')
                            <span class="badge baru">Baru</span>
                        @endif
                    </td>

                    <td>
                        {{ $log->admin->name ?? '-' }}
                    </td>
                    <td>
                        <a href="{{ route('admin.permohonan.show', $log->id) }}" class="btn-view">
                            Lihat
                        </a>
                    </td>
                    <td>{{ $log->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $logs->links() }}
        </div>
    </div>

</div>

@endsection
