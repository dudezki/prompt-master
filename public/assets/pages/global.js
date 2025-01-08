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
        },
        initCreateTagsinput: function() {
            $('#tags_input', document).tagsinput();
        },
        init: function() {
            this.initCreatePrompt();
        }
    }
}();
