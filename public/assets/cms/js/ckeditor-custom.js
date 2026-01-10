window.CKEditorInsertMedia = function (file) {
    let editor = CKEDITOR.instances.description;

    if (!editor) return;

    let el;

    switch (file.type) {
        case 'audio':
            el = editor.document.createElement('audio');
            el.setAttribute('controls', 'controls');
            el.setAttribute('src', file.path);
            el.setStyle('max-width', '100%');
            break;

        case 'video':
            el = editor.document.createElement('video');
            el.setAttribute('controls', 'controls');
            el.setAttribute('src', file.path);
            el.setStyle('width', '100%');
            el.setStyle('max-width', '600px');
            break;

        case 'image':
            let src = new URL(file.path);

            el = editor.document.createElement('img');
            el.setAttribute('src', src.origin + src.pathname);
            el.setAttribute('alt', file.alt || '');
            el.setStyle('width', '100%');
            el.setStyle('max-width', '600px');
            break;
    }

    editor.insertElement(el);
};

CKEDITOR.plugins.add('mediaupload', {
    icons: 'audio,video,image',

    init: function (editor) {

        editor.addCommand('openImageLibrary', {
            exec: function (editor) {
                window.CKEDITOR_MEDIA_MODE = true;
                window.currentCkEditorInstance = editor;

                $('.btn-attach[data-type="image"]').trigger('click');
            }
        });

        editor.addCommand('openAudioLibrary', {
            exec: function (editor) {
                window.CKEDITOR_MEDIA_MODE = true;
                window.currentCkEditorInstance = editor;

                $('.btn-attach[data-type="audio"]').trigger('click');
            }
        });

        editor.addCommand('openVideoLibrary', {
            exec: function (editor) {
                window.CKEDITOR_MEDIA_MODE = true;
                window.currentCkEditorInstance = editor;

                $('.btn-attach[data-type="video"]').trigger('click');
            }
        });

        editor.ui.addButton('Image', {
            label: 'Картинка',
            command: 'openImageLibrary',
            toolbar: 'insert',
            icon: 'image'
        });

        editor.ui.addButton('Audio', {
            label: 'Аудио',
            command: 'openAudioLibrary',
            toolbar: 'insert',
        });

        editor.ui.addButton('Video', {
            label: 'Видео',
            command: 'openVideoLibrary',
            toolbar: 'insert',
        });
    }
});



CKEDITOR.dialog.add('audioDialog', function (editor) {
    return {
        title: 'Загрузка аудио',
        minWidth: 400,
        minHeight: 100,

        contents: [{
            id: 'upload',
            elements: [{
                type: 'file',
                id: 'file',
                label: 'Выберите аудиофайл',
                validate: CKEDITOR.dialog.validate.notEmpty("Файл обязателен")
            }]
        }],

        onOk: function () {
            let dialog = this;
            let fileInput = dialog.getContentElement('upload', 'file').getInputElement().$;

            let formData = new FormData();
            formData.append('file', fileInput.files[0]);

            fetch('/admin/upload/audio', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    let audio = editor.document.createElement('audio');
                    audio.setAttribute('controls', 'controls');
                    audio.setAttribute('src', data.url);

                    editor.insertElement(audio);
                });
        }
    };
});

CKEDITOR.dialog.add('videoDialog', function (editor) {
    return {
        title: 'Загрузка видео',
        minWidth: 400,
        minHeight: 100,

        contents: [{
            id: 'upload',
            elements: [{
                type: 'file',
                id: 'file',
                label: 'Выберите видеофайл',
                validate: CKEDITOR.dialog.validate.notEmpty("Файл обязателен")
            }]
        }],

        onOk: function () {
            let dialog = this;
            let fileInput = dialog.getContentElement('upload', 'file').getInputElement().$;

            let formData = new FormData();
            formData.append('file', fileInput.files[0]);

            fetch('/admin/upload/video', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    let video = editor.document.createElement('video');
                    video.setAttribute('controls', 'controls');
                    video.setAttribute('src', data.url);
                    video.setStyle('max-width', '100%');

                    editor.insertElement(video);
                });
        }
    };
});

CKEDITOR.replace('description', {
    extraPlugins: 'mediaupload',
    toolbar: 'Full',

    filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form',

    extraAllowedContent: [
        'audio[*]{*}(*)',
        'video[*]{*}(*)',
        'source[*]{*}(*)',
        'img[*]{*}(*)'
    ].join(';')
});