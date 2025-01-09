
<!-- Offcanvas Add New -->
<form class="offcanvas offcanvas-end" style="width: 35%;" tabindex="-1" id="offcanvasAddNew" aria-labelledby="offcanvasAddNewLabel" method="post" action="/prompt/add">
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

                    <div class="dropzone-preview-template d-none" id="file-previews-template">
                        <div class="dz-preview dz-file-preview" data-bs-toggle="tooltip" title="Click to make this as a default cover">
                            <div class="dz-image">
                                <img data-dz-thumbnail />
                            </div>
                            <div class="dz-details">
                                <div class="dz-size"><span data-dz-size></span></div>
                                <div class="dz-filename"><span data-dz-name></span></div>

                                <a class="btn btn-secondary btn-sm show mt-2" href="javascript:void(0);" data-lightbox="dropzone" >
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </div>

                            <!-- Add radio input for cover image -->
                            <div class="form-check dz-radio">
                                <input class="form-check-input" type="radio" name="is_cover" value="0">
                            </div>

                            <!-- Add delete button -->
                            <button type="button" class="dz-remove">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>

                    <div class="dropzone-previews"></div>

                    <div id="file-upload-controls" class="dz-controls d-none" style="margin-top: 5px;">
                        <button type="button" class="btn btn-sm btn-danger" id="remove-files">Remove Files</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <hr class="m-0">
    <div class="offcanvas-footer p-4 d-flex flex-row justify-content-between">
        <button type="submit" class="btn btn-primary">Save</button>
        <div class="d-flex flex-row gap-2">
            <span class="align-self-center">Activate this if the prompt is not safe for work.</span>
            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
                <label class="btn btn-outline-warning" for="btncheck1">NSFW</label>
            </div>
        </div>
    </div>
</form>
