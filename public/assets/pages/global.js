const GLOBAL = function() {
    let fileBlobs = [];

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    let showErrorToast = (message) => {
        toastr["error"](message)
    }
    let showSuccessToast = (message) => {
        toastr["success"](message)
    }


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
            let removeFiles = document.getElementById('remove-files');

            Dropzone.autoDiscover = false;

            let myDropzone = new Dropzone("#file-dropzone", {
                url: "/internal/pm/upload.php",
                autoProcessQueue: false,
                parallelUploads: 100,
                dictDefaultMessage: "Drag files here or click to upload generation sample(s).",
                previewTemplate: document.querySelector('#file-previews-template').innerHTML,
                init: function() {
                    this.on("addedfile", function(file) {


                        file.previewElement.dropzoneFile = file;

                        let reader = new FileReader();
                        reader.onload = function(event) {
                            let base64String = event.target.result.split(',')[1]; // Remove the prefix
                            let hiddenInput = document.createElement("input");
                            hiddenInput.type = "hidden";
                            hiddenInput.name = "file_blob[]";
                            hiddenInput.className = "file-blob";
                            hiddenInput.value = base64String;

                            file.previewElement.appendChild(hiddenInput);

                            // Set the href attribute of the [a] tag to the base64 image URL
                            let aTag = file.previewElement.querySelector('a');
                            aTag.href = event.target.result;
                            aTag.setAttribute('data-lightbox', 'dropzone'); // Ensure all images are in the same lightbox group
                        };

                        reader.readAsDataURL(file);

                        $('#file-upload-controls', document).removeClass('d-none');

                        $('[data-bs-toggle="tooltip"]', document).tooltip();

                        // Select the first image as image-preview-selected and check the radio button
                        if ($('.dz-preview.image-preview-selected', document).length === 0) {
                            $(file.previewElement).addClass('image-preview-selected');
                            $(file.previewElement).find('input[type="radio"]').prop('checked', true);
                        }
                    });

                    this.on("removedfile", function(file) {
                        // check if there is still files in the dropzone
                        if (this.files.length === 0) {
                            $('#file-upload-controls', document).addClass('d-none');
                        }
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

                    $(document).on('click', '.dz-preview .show', function() {
                        lightbox.start($(this).find('a')[0]);
                        lightbox.option({
                            'resizeDuration': 200,
                            'wrapAround': true
                        });
                    });

                    // Handle delete button click
                    $(document).on('click', '.dz-remove', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        let file = $(this).closest('.dz-preview').get(0).dropzoneFile;
                        let base64String = file.previewElement.querySelector('.file-blob').value;

                        // Remove the base64 string from the array
                        fileBlobs = fileBlobs.filter(blob => blob !== base64String);

                        $(this).closest('.dz-preview').fadeOut(300, function() {
                            myDropzone.removeFile(file);
                        });
                    });

                    $(document).on('click', '.dz-preview', function() {
                        $('.dz-preview', document).removeClass('image-preview-selected');
                        $(this).addClass('image-preview-selected');
                        $(this).find('input[type="radio"]').prop('checked', true);
                    });

                    removeFiles.addEventListener("click", function() {
                        myDropzone.removeAllFiles();
                        fileBlobs = []; // Clear the array when all files are removed
                    });
                }
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

                // Append the file blobs to the formData
                fileBlobs.forEach((blob, index) => {
                    formData.append(`file_blob[${index}]`, blob);
                });

                let url = form.attr('action');
                let method = form.attr('method');

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    beforeSend: function() {
                        // bootstrap spinner visible in submit button
                        form.find('[type="submit"] .spinner-border').removeClass('d-none');
                        form.find('.button-text').text('Sending...');
                    }
                }).done(function(d) {

                    if(d.status === 'error') {
                        showErrorToast(d.message);
                    }else {
                        if (typeof MAIN !== 'undefined') {
                            MAIN.drawPromptCardHtml(d.prompt, 'prepend');
                        }
                        showSuccessToast(d.message);
                    }

                    // remove spinner in submit button
                    form.find('[type="submit"] .spinner-border').addClass('d-none');
                    form.find('.button-text').text('Save');
                }).fail(function(e) {
                    console.log(e);
                    // remove spinner in submit button
                    form.find('[type="submit"] .spinner-border').addClass('d-none');
                    form.find('.button-text').text('Save');
                });
            });
        },
        init: function() {
            this.initCreatePrompt();
        }
    }
}();
