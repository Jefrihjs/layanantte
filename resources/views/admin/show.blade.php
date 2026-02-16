@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<div class="admin-wrapper">

    <div class="table-card">
        <h3>Detail Permohonan</h3>

        <p style="margin:10px 0 20px;">
            Status:
            @if($log->status == 'pending')
                <span class="badge-pending">Pending</span>
            @else
                <span class="badge-diproses">
                    Diproses oleh {{ $log->admin->name }}
                </span>
            @endif
        </p>
        
        <table class="detail-table">
            <tr>
                <th>Tanggal</th>
                <td>{{ \Carbon\Carbon::parse($log->tanggal)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $log->nama }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>{{ $log->nik }}</td>
            </tr>
            <tr>
                <th>NIP</th>
                <td>{{ $log->nip ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>{{ $log->jabatan }}</td>
            </tr>
            <tr>
                <th>Unit Kerja</th>
                <td>{{ $log->unit_kerja }}</td>
            </tr>
            <tr>
                <th>No HP</th>
                <td>{{ $log->no_hp }}</td>
            </tr>
            <tr>
                <th>Jenis</th>
                <td>{{ $log->jenis_permohonan }}</td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>{{ $log->keterangan }}</td>
            </tr>
        </table>

        @if($log->status == 'pending')
            <form method="POST" action="{{ route('admin.permohonan.proses', $log->id) }}">
                @csrf
                <button type="submit" class="btn-proses">
                    Proses Permohonan
                </button>
            </form>
        @endif

        <br>
        <a href="{{ route('admin.permohonan') }}" class="btn-view">
            Kembali
        </a>

    </div>

</div>

@endsection
