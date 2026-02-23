@extends('layouts.app')

@section('content')
<h2>Tambah User</h2>

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <div>
        <label>Nama</label><br>
        <input type="text" name="name">
    </div>

    <div>
        <label>Email</label><br>
        <input type="email" name="email">
    </div>

    <div>
        <label>Password</label><br>
        <input type="password" name="password">
    </div>

    <br>
    <button type="submit">Simpan</button>
</form>
@endsection