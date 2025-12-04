@extends('layouts.public')

@section('title', 'Admin Login')

@section('content')
    <h2>Admin Login</h2>

    @if($errors->any())
        <div style="color:red;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div>
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>
@endsection
