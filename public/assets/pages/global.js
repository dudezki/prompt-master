const GLOBAL = function() {
    return {
        initCreatePrompt: function() {
            // on change base_model_local_file get file name and add to base_model_file_name
            $(document).on('change', '#base_model_local_file', function() {
                let fileName = $(this).val().split('\\').pop().split('/').pop();
                let fileNameWithoutExtension = fileName.substring(0, fileName.lastIndexOf('.')) || fileName;
                $('#base_model_file_name', document).val(fileNameWithoutExtension);
            });
            this.initCreateDropzone();
            this.initCreateTagsinput();
            this.initCreatePromptForm();
        },
        initCreateDropzone: function() {
            let uploadFiles = document.getElementById('upload-files');
            let removeFiles = document.getElementById('remove-files');

            Dropzone.autoDiscover = false;

            let myDropzone = new Dropzone("#file-dropzone", {
                url: "/internal/pm/upload.php",
                autoProcessQueue: false,
                parallelUploads: 100,
                dictDefaultMessage: "Drag files here or click to upload an attachment(s).",
                previewTemplate: document.querySelector('#file-previews-template').innerHTML,
                init: function() {
                    this.on("addedfile", function(file) {
                        file.previewElement.dropzoneFile = file;
                        console.log("File added:", file);

                        let reader = new FileReader();
                        reader.onload = function(event) {
                            let base64String = event.target.result.split(',')[1]; // Remove the prefix
                            let hiddenInput = document.createElement("input");
                            hiddenInput.type = "hidden";
                            hiddenInput.name = "file_blob[]";
                            hiddenInput.className = "file-blob";
                            hiddenInput.value = base64String;

                            file.previewElement.appendChild(hiddenInput);
                        };

                        reader.readAsDataURL(file);

                        document.getElementById("file-upload-controls").classList.remove("hidden");

                        $('[data-bs-toggle="tooltip"]', document).tooltip();
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

                    // $(document).on('click', '.dz-preview', function() {
                    //     var imgSrc = $(this).find('img').attr('src');
                    //     lightbox.open(imgSrc);
                    // });

                    // Handle delete button click
                    $(document).on('click', '.dz-remove', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        let file = $(this).closest('.dz-preview').get(0).dropzoneFile;
                        $(this).closest('.dz-preview').fadeOut(300, function() {
                            myDropzone.removeFile(file);
                        });
                    });

                    $(document).on('click', '.dz-preview', function() {
                        $('.dz-preview', document).removeClass('image-preview-selected');
                        $(this).addClass('image-preview-selected');
                        $(this).find('input[type="radio"]').prop('checked', true);
                    });
                }
            });

            removeFiles.addEventListener("click", function() {
                myDropzone.removeAllFiles();
            });

            uploadFiles.addEventListener("click", function() {
                myDropzone.processQueue();
            });
        },
        initCreateTagsinput: function() {
            $('#tags_input', document).tagsinput();
        },
        initCreatePromptForm: function() {
            $(document).on('submit', '#offcanvasAddNew', function(e) {
               e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                    }
                })
            });
        },
        init: function() {
            this.initCreatePrompt();
        }
    }
}();
