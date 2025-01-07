const MAIN = function() {
    let handlerInit = function() {
        $('[data-bs-toggle="tooltip"]').tooltip();

        // on change base_model_local_file get file name and add to base_model_file_name
        $(document).on('change', '#base_model_local_file', function() {
            let fileName = $(this).val().split('\\').pop().split('/').pop();
            let fileNameWithoutExtension = fileName.substring(0, fileName.lastIndexOf('.')) || fileName;
            $('#base_model_file_name', document).val(fileNameWithoutExtension);
        });

        $(document).on('click', '#btn_show_content', function() {
            let parentDiv = $(this).closest('.gallery-square');
            parentDiv.toggleClass('content-shown nsfw');

            if (parentDiv.hasClass('content-shown')) {
                $(this).html('<i class="bi bi-eye-slash"></i>');
            } else {
                $(this).html('<i class="bi bi-eye"></i>');
            }
        });

        handlerDropzone();
        handlerSelect2Tools();
    }

    let handlerDropzone = () => {
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
    }

    let handlerSelect2Tools = () => {
        $('#select2_tool_tagging', document).select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#select2_tool_tagging').closest('.form-group'),
            ajax: {
                url: '/api/tools', // Replace with your API endpoint
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: true // add additional parameters
                };
            },
            templateResult: function (data) {
                var $result = $("<span></span>");

                $result.text(data.text);

                if (data.newTag) {
                    $result.append(" <em>(new)</em>");
                }

                return $result;
            }
        });
    }
    return {
        init: handlerInit,
    }
}();
