@extends('layouts.public')

@section('title', $album->name)

@section('content')
<h1 class="mb-3">{{ $album->name }}</h1>

@if($album->description)
    <p>{{ $album->description }}</p>
@endif

@if($album->images->count())
    <div class="row">
        @foreach($album->images as $image)
            @php
                $imageUrl = asset('storage/'.$image->image_path);
                $imageTitle = $image->title ?: $album->name;
            @endphp

            <div class="col-md-3 mb-4">
                <div class="card h-100">

                    {{-- Thumbnail image (click opens modal) --}}
                    <img src="{{ $imageUrl }}"
                         class="card-img-top open-image"
                         style="height:160px; object-fit:cover; cursor:pointer;"
                         data-image="{{ $imageUrl }}"
                         data-title="{{ $imageTitle }}">

                    <div class="card-body">
                        @if($image->title)
                            <h5 class="card-title">{{ $image->title }}</h5>
                        @endif

                        @if($image->description)
                            <p class="card-text">{{ $image->description }}</p>
                        @endif
                    </div>

                    {{-- Buttons --}}
                    <div class="card-footer d-flex justify-content-between">

                        {{-- VIEW BUTTON --}}
                        <button class="btn btn-sm btn-primary open-image"
                                data-image="{{ $imageUrl }}"
                                data-title="{{ $imageTitle }}">
                            View
                        </button>

                        {{-- DOWNLOAD BUTTON --}}
                        <a href="{{ $imageUrl }}" class="btn btn-sm btn-outline-secondary" download>
                            Download
                        </a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>No images in this album yet.</p>
@endif

<a href="{{ route('gallery.index') }}">← Back to albums</a>

{{-- FULL SCREEN IMAGE MODAL --}}
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImageTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" style="width:100%; max-height:85vh; object-fit:contain;">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    let modal = new bootstrap.Modal(document.getElementById('imageModal'));

    document.querySelectorAll(".open-image").forEach(btn => {
        btn.addEventListener("click", function () {

            let src = this.dataset.image;
            let title = this.dataset.title;

            document.getElementById("modalImage").src = src;
            document.getElementById("modalImageTitle").innerText = title;

            modal.show();
        });
    });
});
</script>
@endpush
