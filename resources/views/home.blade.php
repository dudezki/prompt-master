@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/dropzone.css')}}" />
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
        .gallery-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            padding: 0.5rem;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            z-index: 3;
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
                            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasView{{ $item->id }}">View</button>
                            @if($item->is_nsfw)
                                <button class="btn btn-danger btn-sm" id="btn_show_content">Show</button>
                            @endif
                        </div>
                    </div>

                    <h5 class="gallery-title mx-3 mt-3 d-flex flex-row">{{ $item->title }}
                        <span class="ms-auto nsfw_label badge bg-danger">NSFW</span>
                    </h5>

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
    <form class="offcanvas offcanvas-end" style="width: 40%;" tabindex="-1" id="offcanvasAddNew" aria-labelledby="offcanvasAddNewLabel" method="post" action="/prompt/add" id="frm_add_prompt">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasAddNewLabel">Add New</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="description">Description</label>
                        <textarea rows="10" class="form-control" id="description" name="description" required></textarea>
                    </div>


                    <div class="form-group mb-2 dz-container">
                        {{-- dropzone here --}}
                        <div id="file-dropzone" class="dropzone"></div>
                        <div id="file-upload-controls" class="dz-controls hidden" style="margin-top: 5px;">
                            <button type="button" class="btn btn-sm btn-success" id="upload-files">Attach Files</button>
                            <button type="button" class="btn btn-sm btn-danger" id="remove-files">Remove Files</button>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <div class="d-flex flex-row gap-3">
                            <label for="category_id" class="text-muted">Category</label>
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="category_{{ $category->id }}" name="category_id[]" value="{{ $category->id }}">
                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                        {!! $category->svg_icon !!} {{ $category->description }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="offcanvas-footer p-4">
            <button class="btn btn-primary">Save</button>
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
    <script src="{{asset('assets/plugins/dropzone-min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

            $(document).on('click', '#btn_show_content', function() {
                let parentDiv = $(this).closest('.gallery-square');
                parentDiv.toggleClass('content-shown nsfw');

                if (parentDiv.hasClass('content-shown')) {
                    $(this).text('Hide');
                } else {
                    $(this).text('Show');
                }
            });


            let uploadFiles = document.getElementById('upload-files');
            let removeFiles = document.getElementById('remove-files');

            Dropzone.autoDiscover = false;

            let myDropzone = new Dropzone("#file-dropzone", {
                url: "/internal/pm/upload.php",
                autoProcessQueue: false,
                parallelUploads: 100,
                dictDefaultMessage: "Drag files here or click to upload an attachment(s).",
                init: function() {
                    this.on("addedfile", function(file) {
                        console.log("File added:", file);

                        let reader = new FileReader();
                        reader.onload = function(event) {

                            let hiddenInput = document.createElement("input");
                            hiddenInput.type = "hidden";
                            hiddenInput.name = "file_data[]";
                            hiddenInput.value = event.target.result;

                            document.getElementById("f").appendChild(hiddenInput);
                        };

                        reader.readAsDataURL(file);

                        document.getElementById("file-upload-controls").classList.remove("hidden");
                    });

                    this.on("sending", function(file, xhr, formData) {
                        //formData.append("dtr_log_id", '');
                    });

                    this.on("removedfile", function(file) {
                        document.getElementById("file-upload-controls").classList.add("hidden");
                    });

                    this.on("success", function(file, response) {
                        console.log("File uploaded successfully:", response);
                    });

                    this.on("error", function(file, errorMessage) {
                        console.log("Error uploading file:", errorMessage);
                    });

                    document.addEventListener("paste", (event) => {
                        let items = (event.clipboardData || event.originalEvent.clipboardData).items;
                        for (let index in items) {
                            let item = items[index];
                            if (item.kind === "file") {
                                let blob = item.getAsFile();
                                this.addFile(blob);
                            }
                        }
                    });
                }
            });

            removeFiles.addEventListener("click", function() {
                myDropzone.removeAllFiles();
            });

            uploadFiles.addEventListener("click", function() {
                myDropzone.processQueue();
            });
        });
    </script>
@endpush
