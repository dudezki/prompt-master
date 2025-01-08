const MAIN = function() {
    let handlerInit = function() {
        $('[data-bs-toggle="tooltip"]').tooltip();

        $(document).on('click', '#btn_show_content', function() {
            let parentDiv = $(this).closest('.gallery-square');
            parentDiv.toggleClass('content-shown nsfw');

            if (parentDiv.hasClass('content-shown')) {
                $(this).html('<i class="bi bi-eye-slash"></i>');
            } else {
                $(this).html('<i class="bi bi-eye"></i>');
            }
        });
    }


    return {
        init: handlerInit,
    }
}();
