@extends('layouts.public')

@section('title', 'Financial Reports')

@section('content')
    <h1>Financial Reports</h1>

    @if($reports->count())
        <ul>
            @foreach($reports as $report)
                <li style="margin-bottom:10px;">
                    <strong>
                        <a href="{{ route('financial.show', $report->id) }}">
                            {{ $report->title }}
                        </a>
                    </strong>
                    <br>
                    <small>{{ $report->published_date }}</small>
                    @if($report->description)
                        <br>{{ \Illuminate\Support\Str::limit($report->description, 120) }}
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>No financial reports available.</p>
    @endif
@endsection
