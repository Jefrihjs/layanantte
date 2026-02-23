@extends('layouts.app')

@section('content')
<h2>Daftar User</h2>

<a href="{{ route('users.create') }}">+ Tambah User</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5">
    <tr>
        <th>Nama</th>
        <th>Email</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
        </tr>
    @endforeach
</table>
@endsection