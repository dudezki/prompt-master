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
            <button class="btn text-light" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddNew">
                <i class="bi bi-plus"></i>
            </button>
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

                    <div class="gallery-title d-flex flex-row gap-3">
                        <img class="rounded float-start rounded-circle" src="{{ asset('assets/uploads/cards/1/cover.jpeg') }}" alt="" style="width: 50px; height: 50px;">
                        <div class="d-flex flex-column flex-grow-1">
                            <div class="d-flex flex-row justify-content-between gap-2">
                                <p class="mb-0 small">{{ $item->title }}</p>
                                <span class="ms-auto nsfw_label badge bg-danger small align-self-center">NSFW</span>
                            </div>
                            <span class="text-muted " style="font-size: 12px;">DUDEZKIE</span>
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

    <!-- Offcanvas Add New -->
    <form class="offcanvas offcanvas-end" style="width: 35%;" tabindex="-1" id="offcanvasAddNew" aria-labelledby="offcanvasAddNewLabel" method="post" action="/prompt/add" id="frm_add_prompt">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasAddNewLabel">Add New</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <hr class="m-0">
        <div class="offcanvas-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Details</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab_attachments" type="button" role="tab" aria-controls="tab_attachments" aria-selected="false">Attachment and Cover</button>
                </li>
            </ul>
            <div class="tab-content py-3" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="description">Positive Prompt</label>
                                <textarea rows="4" class="form-control" id="description" name="description" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Negative Prompt</label>
                                <textarea rows="2" class="form-control" id="description" name="description" required></textarea>
                            </div>

                            <div class="p-2 border rounded mb-3">
                                <div class="form-group mb-2">
                                    <label for="tag_id" class="text-muted">Base Model</label>
                                    <input type="text" class="form-control" id="base_model_file_name" name="base_model_file_name" required>
                                </div>
                                <div class="form-group ">
                                    <label for="tag_id" class="text-muted">Local File</label>
                                    <input id="base_model_local_file" accept=".safetensors" type="file" class="form-control" name="base_model_local_file" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tools_tagging">Tool Used</label>
                                <input class="form-control" type="text" value="lora1,lora2" id="tags_input" />
                            </div>


                            <div class="form-group mb-2">
                                <div class="d-flex flex-row gap-3">
                                    <label for="category_id" class="text-muted">Categories</label>
                                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                        @foreach($categories as $category)
                                            <input type="checkbox" class="btn-check" id="btncheck_{{$category->id}}" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-secondary" for="btncheck_{{$category->id}}">{!! $category->svg_icon !!} {{ $category->description }}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab_attachments">


                    <div class="form-group mb-2 dz-container">
                        {{-- dropzone here --}}
                        <div id="file-dropzone" class="dropzone"></div>
                        <div id="file-upload-controls" class="dz-controls hidden" style="margin-top: 5px;">
                            <button type="button" class="btn btn-sm btn-success" id="upload-files">Attach Files</button>
                            <button type="button" class="btn btn-sm btn-danger" id="remove-files">Remove Files</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <hr class="m-0">
        <div class="offcanvas-footer p-4 d-flex flex-row justify-content-between">
            <button class="btn btn-primary">Save</button>
            <div class="d-flex flex-row gap-2">
                <span class="align-self-center">Activate this if the prompt is not safe for work.</span>
                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
                    <label class="btn btn-outline-warning" for="btncheck1">NSFW</label>
                </div>
            </div>
        </div>
    </form>

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


