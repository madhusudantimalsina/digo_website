@extends('layouts.public')

@section('title', 'Contact Us')

@section('content')
    <h1>Contact Us</h1>

    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="padding:10px; background:#f8d7da; color:#721c24; margin-bottom:15px;">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Your Full Name</label><br>
            <input type="text" name="full_name"
                   value="{{ old('full_name') }}"
                   style="width:100%; padding:8px;" required>
        </div>

        <div class="mb-3">
            <label>Email</label><br>
            <input type="email" name="email"
                   value="{{ old('email') }}"
                   style="width:100%; padding:8px;" required>
        </div>

        <div class="mb-3">
            <label>Description / Message</label><br>
            <textarea name="message" rows="5"
                      style="width:100%; padding:8px;" required>{{ old('message') }}</textarea>
        </div>

        <button type="submit" style="padding:8px 16px;">Submit</button>
    </form>
@endsection
