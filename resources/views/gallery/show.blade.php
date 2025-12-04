@extends('layouts.public')

@section('title', $album->title.' | Gallery')

@section('content')
<section style="padding: 60px 0 20px; background:#f8fafc;">
    <div class="container">
        <a href="{{ route('gallery.index') }}" style="color:#3182ce; text-decoration:none;">
            ← Back to Gallery
        </a>
        <h1 style="font-size:32px; font-weight:700; margin-top:10px;">
            {{ $album->title }}
        </h1>
        @if($album->description)
            <p style="color:#555; max-width:700px;">
                {{ $album->description }}
            </p>
        @endif
    </div>
</section>

<section style="padding: 30px 0 60px;">
    <div class="container">
        <div class="row">
            @forelse($album->images as $image)
                <div class="col-md-3 mb-4">
                    <div style="border-radius:8px; overflow:hidden; border:1px solid #e2e8f0;">
                        <div style="height:200px; overflow:hidden;">
                            <img src="{{ asset('storage/'.$image->image_path) }}" 
                                 alt="{{ $image->caption ?? 'Image' }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        @if($image->caption)
                            <div style="padding:8px 10px; font-size:13px; color:#4a5568;">
                                {{ $image->caption }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-muted">No images in this album yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
