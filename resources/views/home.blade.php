@extends('layouts.app')

@push('css')
    @cssLink('plugins/dropzone.css')
    @cssLink('pages/home/main.css')
    @cssLink('plugins/bootstrap-tagsinput/0.8.0/css/bootstrap-tagsinput.css')
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
            <button class="btn text-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter">
                <i class="bi bi-funnel"></i>
            </button>
        </div>
    </div>



    <div class="row">
        @foreach($items as $item)
            <div class="col-md-2 mb-4">
                <div style="min-height: 40vh; max-height: 50vh; width: 100%; background-image: url('{{ asset('assets/uploads/cards/1/cover.jpeg') }}'); background-size: cover;" class="gallery-square position-relative @if($item->is_nsfw) nsfw @endif">
                    <div class="overlay d-flex flex-column justify-content-center align-items-center">
                        <p class="gallery-text">{{ Str::limit($item->description, 100) }}</p>
                        <div class="d-flex flex-row gap-3">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasView{{ $item->id }}">
                                <i class="bi bi-search"></i>
                            </button>
                            @if($item->is_nsfw)
                                <button class="btn btn-warning btn-sm" id="btn_show_content">
                                    <i class="bi bi-eye"></i>
                                </button>
                            @endif
                            <button class="btn btn-danger btn-sm" data-id="{{ $item->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="gallery-title d-flex flex-row gap-2">
                        <picture class="rounded float-start rounded-circle align-self-center">
                            @if($item->author_avatar)
                                <img src="data:image/png;base64,{{ $item->author_avatar }}" alt="User Avatar" class="rounded-circle" width="40" height="40">
                            @else
                                <img src="{{ asset('assets/images/default-avatar.png') }}" alt="Default Avatar" class="rounded-circle" width="40" height="40">
                            @endif
                        </picture>
                        <div class="d-flex flex-column gap-0 flex-grow-1 align-self-center">
                            <div class="d-flex flex-row justify-content-between gap-2">
                                <p class="mb-0 @if($item->is_nsfw) text-danger @else text-info @endif" style="font-size: 13px;">{{ $item->title }}</p>
                                <span class="ms-auto nsfw_label badge bg-danger small align-self-center">NSFW</span>
                            </div>
                            <span class="text-muted " style="font-size: 12px;">{{ $item->author }}</span>
                        </div>
                    </div>

                    @foreach($item->tagging as $tagging)
                        <a href="javascript:void(0);" class="gallery-icon" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ $tagging->category->description }}">
                            {!! $tagging->category->svg_icon !!}
                        </a>
                    @endforeach
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
    @scriptLink('plugins/dropzone-min.js')
    @scriptLink('plugins/select2/2.4.0.13/js/select2.full.min.js')
    @scriptLink('plugins/bootstrap-tagsinput/0.8.0/js/bootstrap-tagsinput.min.js')
    @scriptLink('pages/home/main.js')

    <script type="text/javascript">
        $(document).ready(function() {
            MAIN.init();
        })
    </script>
@endpush


