const MAIN = function() {
    let prompts = [];
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

        $(document).on('click', '.gallery-square .btn-delete', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let id = $(this).data('id');
            let parentDiv = $(this).closest('.gallery-square'); // Store reference to parentDiv
            $.ajax({
                url: '/prompt/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(d) {
                parentDiv.animate({width: '0px', height: '0px', opacity: 0}, 300, function () {
                    parentDiv.remove();
                    rearrangeGallerySquares();
                });
            }).fail(function(e) {
                console.log(e);
            });
        });

        $(document).on('click', '.gallery-bullet', function(e) {
            e.preventDefault();
            // Update the active bullet
            $('.gallery-bullet').removeClass('active');
            $(this).addClass('active');

            let gallerySquare = $(this).closest('.gallery-square');
            let galleryCard = gallerySquare.find('.gallery-card');

            renderCardBackground(galleryCard, $(this).data('id')).then(function(imageUrl) {
                galleryCard.css('background-image', `url(${imageUrl})`);
            });
        });


        $(document).on('shown.bs.offcanvas', '#offcanvasView', function(e) {
            let id = $(e.relatedTarget).data('id');
            let offcanvas = $(this);
            let offcanvasBody = offcanvas.find('.offcanvas-body');
            let offcanvasTitle = offcanvas.find('.offcanvas-title');

            $.ajax({
                url: '/prompt/' + id,
                type: 'GET',
                success: function(d) {
                    offcanvasTitle.html(d.data.prompt.title);
                    offcanvasBody.html(d.view);
                }
            });

            offcanvas.on('mouseenter', '.form-control', function() {
                $(this).find('.prompt-copy').removeClass('d-none');
            });

            offcanvas.on('mouseleave', '.form-control', function() {
                $(this).find('.prompt-copy').addClass('d-none');
            });
        });

        $(document).on('hidden.bs.offcanvas', '#offcanvasView', function(e) {
            let offcanvas = $(this);
            let offcanvasBody = offcanvas.find('.offcanvas-body');
            let offcanvasTitle = offcanvas.find('.offcanvas-title');

            offcanvasTitle.html('');
            offcanvasBody.html('');
        });

        $(document).on('click', '.prompt-copy', function() {
            let copyText = $(this).closest('.form-control').find('.prompt-content').text();
            navigator.clipboard.writeText(copyText).then(function() {
                toastr.success('Copied to clipboard');
            }).catch(function(error) {
                toastr.error('Failed to copy text');
            });
        })

        handlePromptContents();
    }

    let renderCardBackground = (galleryCard, id) => {
        return $.ajax({
            url: '/card/' + id,
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            beforeSend: function() {
                galleryCard.addClass('gallery-loading');
            }
        }).then(function(data) {
            galleryCard.removeClass('gallery-loading');
            return URL.createObjectURL(data);
        }).catch(function(error) {
            galleryCard.removeClass('gallery-loading');
            return '/assets/images/default-card.png';
        });
    }

    let rearrangeGallerySquares = () => {
        $('#prompts_container .gallery-square', document).each(function(index) {
            $(this).css('order', index);
        });
    }

    let handlePromptContents = () => {
        $.ajax({
            url: '/home',
            type: 'GET',
            success: function(data) {
                if (data.count > 0) {
                    prompts = data.items;
                    handlePromptCardHtml(0);
                } else {
                    console.log('No prompts found');
                }
            }
        });
    }

    let handlePromptCardHtml = (i) => {
        if (i < prompts.length) {
            setTimeout(() => {
                drawPromptCardHtml(prompts[i]);
                handlePromptCardHtml(i + 1);
            }, 100); // 500ms delay between each card
        }
    }

    let drawPromptCardHtml = (prompt, position = 'append') => {
        let randomIndex = prompt.cards.length > 0 ? Math.floor(Math.random() * prompt.cards.length) : 0;
        let randomCard = prompt.cards.length > 0 ? prompt.cards[randomIndex] : null;

        let card = $(`<div class="gallery-square image-overlay ${prompt.is_nsfw ? `nsfw` : ``}" style="display: none;">
                        <div style="min-height: 40vh; max-height: 50vh; width: 100%; background-size: cover;" class="gallery-card position-relative gallery-loading ${prompt.is_nsfw ? 'nsfw' : ''}">
                            <div class="overlay d-flex flex-column justify-content-center align-items-center">
                                <p class="gallery-text">${prompt.title.substring(0, 100)}</p>
                                <div class="d-flex flex-row gap-3">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-id="${prompt.id}" data-bs-target="#offcanvasView">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    ${prompt.is_nsfw ? `
                                    <button class="btn btn-warning btn-sm" id="btn_show_content" data-id="${prompt.id}">
                                        <i class="bi bi-eye"></i>
                                    </button>` : ''}
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="${prompt.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="gallery-bullets">
                                    ${prompt.cards.length > 1 ? prompt.cards.map((card, index) => `<a href="javascript:voide(0);" data-id="${card.id}" class="gallery-bullet ${index === randomIndex ? 'active' : ''}">.</a>`).join('') : ''}
                                </div>
                            </div>

                            <span class="loader"></span>
                        </div>

                        <div class="gallery-title d-flex flex-row gap-2">
                            <picture class="rounded float-start rounded-circle align-self-center">
                                ${prompt.author_avatar ? `
                                <img src="data:image/png;base64,${prompt.author_avatar}" alt="User Avatar" class="rounded-circle shadow-sm" width="40" height="40">` : `
                                <img src="/assets/images/default-avatar.png" alt="Default Avatar" class="rounded-circle shadow-sm" width="40" height="40">`}
                            </picture>
                            <div class="d-flex flex-column gap-0 flex-grow-1 align-self-center">
                                <div class="d-flex flex-row justify-content-between gap-2">
                                    <p class="mb-0 ${prompt.is_nsfw ? 'text-danger' : 'text-info'}" style="font-size: 13px;">${prompt.title}</p>
                                    <span class="ms-auto nsfw_label badge bg-danger small align-self-center">NSFW</span>
                                </div>
                                <span class="text-muted" style="font-size: 12px;">${prompt.author}</span>
                            </div>
                        </div>

                        ${prompt.tagging.map(tagging => `
                        <a href="javascript:void(0);" class="gallery-icon" data-bs-toggle="tooltip" data-bs-placement="left" title="${tagging.category.description}">
                            ${tagging.category.svg_icon}
                        </a>`).join('')}
                    </div>`);


        if (randomCard) {
            renderCardBackground($('.gallery-card', card), randomCard.id).then(function(imageUrl) {
                card.find('.gallery-card').css('background-image', `url(${imageUrl})`);
            });
        } else {
            card.find('.gallery-card').css('background-image', 'url(\'/assets/images/default-card.png\')')
                .removeClass('gallery-loading')
        }

        if (position === 'prepend') {
            $('#prompts_container', document).prepend(card);
        } else {
            $('#prompts_container', document).append(card);
        }
        card.fadeIn();
    };

    return {
        init: handlerInit,
        drawPromptCardHtml: function(prompt, position) {
            drawPromptCardHtml(prompt, position);
        }
    }
}();
