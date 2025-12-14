/**
 * Lingva Main Javascript File
 */
"use strict";

let $ = jQuery.noConflict();

/**
 * Lingva Object
 */
window.CKEDITOR_MEDIA_MODE = false;
window.Lingva = {};

(function () {

    Lingva.$window = $(window);
    Lingva.$body = $(document.body);

    /**
     * Get jQuery object
     * @param {string|jQuery} selector
     */
    Lingva.$ = function (selector) {
        return selector instanceof jQuery ? selector : $(selector);
    }

    /**
     * Make a macro task
     * @param {function} fn
     * @param {number} delay
     */
    Lingva.call = function (fn, delay) {
        setTimeout(fn, delay);
    }

    /**
     * @function initMediaFile
     */
    Lingva.initMediaFile = (function () {

        let uploadForm = $('#form-upload, #pres-form-upload');
        let inputYoutube = $('input[name="youtube"]');
        let $button;
        let button;
        let $mediaLibrary = $('.media-library');

        function setContentByFile(file) {
            let id = file.id,
                title = file.title,
                alt = file.alt,
                path = file.path,
                type = file.type,
                before_content = '<div class="col-4"><div class="file-wrap exists-file mt-2 mb-2" data-type="' + type + '">',
                after_content = '</div></div>',
                content;

            switch (type) {
                case 'image':
                    content =
                        '<img class="file" src="' + path + '" style="width: 100%" alt="' + alt + '" data-id="' + id + '" data-title="' + title + '">' +
                        '<h6 class="text-center">' + title + '</h6>';
                    break;
                case 'audio':
                    content =
                        '<div class="play-pause"></div>' +
                        '<audio class="file" src="' + path + '" data-id="' + id + '" data-title="' + title + '"></audio>' +
                        '<h6 class="text-center">' + title + '</h6>';
                    break;
                case 'video':
                    content =
                        '<video class="file" src="' + path + '" width="100%" data-id="' + id + '" data-title="' + title + '"></video>' +
                        '<h6 class="text-center">' + title + '</h6>';
                    break;
                case 'file':
                    content =
                        '<span class="file" data-id="' + id + '" data-title="' + title + '"></span>' +
                        '<h6 class="text-center">' + title + '</h6>';
                    break;
            }
            return before_content + content + after_content;
        }

        // Get gallery by file type
        function getGalleryByType(files) {
            $.each(files, function (key, file) {
                let content = setContentByFile(file);
                $mediaLibrary.append(content);
            });
        }

        // Upload new files
        function uploadFile(file) {
            let content = setContentByFile(file);
            $mediaLibrary.prepend(content);
        }

        function initFillForm(el) {

            let file = el.children('.file'),
                type = el.attr('data-type'),
                id = file.attr('data-id'),
                title = file.attr('data-title'),
                src = file.attr('src'),
                method = 'PUT',
                mediaFile;

            if (button.attr('data-var') === 'question_audio') {
                if (el.hasClass('active')) {
                    el.removeClass('active');
                } else {
                    el.addClass('active');
                }
            } else {
                $('.exists-file, .new-file').removeClass('active');
                el.addClass('active');
            }

            if (type === 'audio') {

                let input = '<input type="hidden" name="audio" value="' + id + '">';

                if (button.attr('data-var') === 'question_audio') {
                    input = '<input type="hidden" name="question_audios[]" value="' + id + '">';
                    method = 'DELETE';
                }

                if (button.attr('data-var') === 'matching_audio') {
                    input = '<input type="hidden" name="matching_audio" value="' + id + '">';
                }

                mediaFile =
                    '<div id="item-' + id + '" class="current-item"><audio src="' + src + '" controls></audio>' +
                    '<div class="small file-remove" data-method="' + method + '">Удалить</div>' + input + '</div>';
            }

            if (type === 'image') {
                let input = '<input type="hidden" name="image" value="' + id + '">',
                    url = '/assets/cms/img/no-image.jpg';

                if (src != null) {
                    url = src;
                }

                if (button.attr('data-var') === 'question_image') {
                    input = '<input type="hidden" name="question_image" value="' + id + '">';
                }

                if (button.attr('data-var') === 'matching_image') {
                    input = '<input type="hidden" name="matching_image" value="' + id + '">';
                }

                if (button.attr('data-var') === 'slide-image') {
                    input = '<input type="hidden" name="slide_images[]" value="' + id + '">';
                    mediaFile =
                        '<div id="slide-item-' + id + '" class="slide-item" draggable="true">' +
                        '<img src="' + url + '" style="width: 100%" alt>'+input+'<i class="la la-close la-2x" data-method="'+method+'"></i>' +
                        '</div>';

                } else {
                    mediaFile =
                        '<div id="item-' + id + '" class="current-item"><img src="' + url + '" width="240" alt>' +
                        '<div class="small file-remove" data-method="' + method + '">Удалить</div>' + input + '</div>';
                }
            }

            if (type === 'video') {
                let input = '<input type="hidden" name="video" value="' + id + '">';
                mediaFile =
                    '<div id="item-' + id + '" class="current-item"><video src="' + src + '" width="240" controls></video>' +
                    '<div class="small file-remove" data-method="' + method + '">Удалить</div>' + input + '</div>';

                inputYoutube.val('');
            }

            if (type === 'file') {
                let input = '<input type="hidden" name="files[]" value="' + id + '">';
                mediaFile =
                    '<div id="item-' + id + '" class="current-item"><span>' + title + '</span>' +
                    '<div class="small file-remove" data-method="' + method + '">Удалить</div>' + input + '</div>';
            }

            addMedia(id, type, mediaFile)
        }

        // Add multiple media if file not exists
        function addMedia(id, type, content) {
            let $wrap = button.parent().find('.preview');
            if (button.attr('data-var') === 'question_audio' || type === 'file') {
                if ($wrap.children('#item-' + id).length === 0) {
                    console.log('Not found!');
                    $wrap.append(content);
                }
            } else if (button.attr('data-var') === 'slide-image') {
                button.before(content);
            } else {
                $wrap.html(content);
            }
        }

        // Remove File
        function removeFile(div) {
            let noImage = '<div class="current-item"><img src="/assets/cms/img/no-image.jpg" width="100" alt></div>';
            let container = div.parent().parent();

            let audio = div.parent().find('audio');
            let image = div.parent().find('img');
            let video = div.parent().find('video');
            let file = div.parent().find('span');

            if (audio.length > 0) {
                div.parent().remove();
            }
            if (image.length > 0) {
                container.html(noImage);
            }
            if (video.length > 0) {
                div.parent().remove();
            }
            if (file.length > 0) {
                div.parent().remove();
            }
        }

        return function () {
            $button = $('.btn-attach');
            $button.on('click', function () {
                let $this = $(this);
                let $file_type = $this.attr('data-type');
                let $file_var = $this.attr('data-var');
                let url = window.location.origin + '/ajax/files/' + $file_type;

                button = $('[data-var="' + $file_var + '"]');
                $mediaLibrary.empty();

                // Получаем галерею по типу файла
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        getGalleryByType(res.files);
                    }
                });
            });

            // Choose files
            // $(document).on('click', '.file-wrap', function () {
            //     initFillForm($(this));
            // });
            $(document).on('click', '.file-wrap', function (e) {

                // 👉 CKEditor режим
                if (window.CKEDITOR_MEDIA_MODE === true) {
                    e.preventDefault();
                    e.stopPropagation();

                    let el = $(this);
                    let file = el.find('.file');

                    let media = {
                        id: file.data('id'),
                        title: file.data('title'),
                        path: file.attr('src'),
                        type: el.data('type'),
                        alt: file.data('title')
                    };

                    if (window.CKEditorInsertMedia) {
                        window.CKEditorInsertMedia(media);
                    }

                    // 🔻 закрываем режим
                    window.CKEDITOR_MEDIA_MODE = false;

                    // закрываем модалку
                    $('.media-modal').modal('hide');
                } else {
                    initFillForm($(this));
                }
            });


            inputYoutube.blur(function () {
                let input = '<input type="hidden" name="video" value="' + $(this).val() + '">';
                let mediaFile = '<div class="current-item">' + input + '</div>';

                $(this).parent().find('.preview').html(mediaFile);
            });

            // Upload Files
            uploadForm.submit(function (e) {
                e.preventDefault();

                let $this = $(this);
                let formData = new FormData(document.getElementById($this.attr('id')));

                $.ajax({
                    url: uploadForm.attr('action'),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (result) {
                        // Add New Images to Gallery
                        $.each(result.files, function (key, file) {
                            uploadFile(file);
                        });

                        // Show Success Message
                        $('.alert').removeClass('hide').html(result.success);
                        setTimeout(function () {
                            $('.alert').addClass('hide');
                        }, 1000);

                        // Click to Choosing file tab
                        setTimeout(function () {
                            $this.closest('.modal-body').find('.choose-aria').trigger('click');
                            // $('#choosing-tab').trigger('click');
                        }, 1000);
                    }
                });
            });


            $(document).on('click', '.slide-item .la-close', function (e) {
                $(this).parent('.slide-item').remove();
            });

            // Remove File From Database
            $(document).on('click', '.file-remove', function (e) {
                e.preventDefault();

                let div = $(this);
                let url = div.attr('data-delete');
                let method = div.attr('data-method');

                if (!url) {
                    removeFile(div);
                } else {
                    let formData = new FormData(document.getElementById("form-update"));
                    $.ajax({
                        url: div.attr('data-delete'),
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method: method,
                        data: formData,
                        cache: false,
                        processData: false,
                        success: function () {
                            removeFile(div);
                        }
                    });
                }
            });
        }
    })();

    Lingva.init = function () {
        Lingva.initMediaFile();
    }

    window.onload = function () {
        Lingva.call(Lingva.init());
    }
})();

