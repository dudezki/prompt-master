@extends('layouts.app')

@push('css')
    <style>
        .gallery-square {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(131, 109, 109, 0.55);
            border-radius: 5px;
            background-size: cover;
            background-position: top center;
        }

        .gallery-square.nsfw::before {
            content: '';
            position: absolute;
            top: -5%;
            left: -5%;
            width: 110%;
            height: 110%;
            background: inherit;
            filter: blur(30px) contrast(200%) saturate(50%) brightness(80%) drop-shadow(0 0 10px black);
            z-index: 1;
            image-rendering: pixelated;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 2;
        }

        .gallery-square:hover .overlay {
            opacity: 1;
        }

        .gallery-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            z-index: 3;
            position: absolute;
            width: 90%;
        }

        .gallery-text {
            font-size: 0.875rem;
            margin-bottom: 1rem;
            z-index: 3;
        }
        .nsfw_label {
            visibility: hidden;
        }
        .gallery-square.nsfw .nsfw_label {
            visibility: visible !important;
        }
    </style>
@endpush

@section('title', __('Dashboard'))

@section('content')
    <div class="d-flex flex-row gap-3 justify-content-between mb-4">
        <div class="d-flex flex-row gap-3 align-content-center">
            <span class="text-muted align-self-center">Categories</span>
            @foreach($categories as $category)
                <a href="" class="btn bg-transparent align-self-center @if($category->id == 1) active @endif">
                    {!! $category->svg_icon !!}
                    {{ $category->description }}
                </a>
            @endforeach
        </div>

        <div class="d-flex flex-row gap-2">
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddNew">Add New</button>
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter">Filter</button>
        </div>
    </div>

    <div class="row">
        @foreach($items as $item)
            <div class="col-md-3">
                <div style="min-height: 400px; max-height: 400px; width: 100%; background-image: url('{{ asset('assets/uploads/cards/1/cover.jpeg') }}'); background-size: cover;" class="gallery-square position-relative @if($item->is_nsfw) nsfw @endif">
                    <div class="overlay d-flex flex-column justify-content-center align-items-center">
                        <p class="gallery-text">{{ Str::limit($item->description, 100) }}</p>
                        <div class="d-flex flex-row gap-3">
                            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasView{{ $item->id }}">View</button>
                            @if($item->is_nsfw)
                                <button class="btn btn-danger btn-sm" id="btn_show_content">Show</button>
                            @endif
                        </div>
                    </div>

                    <h5 class="gallery-title mx-3 mt-3 d-flex flex-row">{{ $item->title }}
                        <span class="ms-auto nsfw_label badge bg-danger">NSFW</span>
                    </h5>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Offcanvas View -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasView" aria-labelledby="offcanvasViewLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasViewLabel">Prompt Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

        </div>
    </div>

    <!-- Offcanvas Add New -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddNew" aria-labelledby="offcanvasAddNewLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasAddNewLabel">Add New</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Add New form content here -->
        </div>
    </div>

    <!-- Offcanvas Filter -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasFilterLabel">Filter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Filter form content here -->
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#btn_show_content').on('click', function() {
                let parentDiv = $(this).closest('.gallery-square');
                parentDiv.toggleClass('content-shown nsfw');

                if (parentDiv.hasClass('content-shown')) {
                    $(this).text('Hide');
                } else {
                    $(this).text('Show');
                }
            });
        });
    </script>
@endpush
