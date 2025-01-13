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




    <div class="row mx-0" id="prompts_container">

    </div>


    <!-- Offcanvas View -->
    <div class="offcanvas offcanvas-end" style="width: 65%;" tabindex="-1" id="offcanvasView" aria-labelledby="offcanvasViewLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="offcanvasViewLabel">Prompt Details</h3>
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
    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            MAIN.init();
        })
    </script>
@endpush


