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

        case 'file':
            el = editor.document.createElement('a');
            el.setAttribute('href', file.href);
            el.setAttribute('target', '_blank');
            el.setText(file.title || 'Скачать файл');
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

window.CKEditorInsertFile = function(file) {
    let editor = CKEDITOR.instances.description;
    if (!editor) return;

    let el = editor.document.createElement('a');
    el.setAttribute('href', file.path);
    el.setAttribute('target', '_blank'); // открывать в новой вкладке
    el.setText(file.name || 'Скачать файл');
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

        editor.addCommand('openFileLibrary', {
            exec: function (editor) {
                window.CKEDITOR_MEDIA_MODE = true;
                window.currentCkEditorInstance = editor;

                $('.btn-attach[data-type="file"]').trigger('click');
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

        editor.ui.addButton('File', {
            label: 'Файл',
            command: 'openFileLibrary',
            toolbar: 'insert',
            icon: 'link'
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

CKEDITOR.dialog.add('fileDialog', function(editor) {
    return {
        title: 'Загрузка файла',
        minWidth: 400,
        minHeight: 100,

        contents: [{
            id: 'upload',
            elements: [{
                type: 'file',
                id: 'file',
                label: 'Выберите файл',
                validate: CKEDITOR.dialog.validate.notEmpty("Файл обязателен")
            }]
        }],

        onOk: function () {
            console.log(1);
            let dialog = this;
            let fileInput = dialog.getContentElement('upload', 'file').getInputElement().$;

            let formData = new FormData();
            formData.append('file', fileInput.files[0]);

            fetch('/admin/upload/file', { // <-- ваш роут для загрузки файлов
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    console.log(data)

                    let link = editor.document.createElement('a');
                    link.setAttribute('href', data.url);
                    link.setAttribute('target', '_blank');
                    link.setText(fileInput.files[0].name);
                    editor.insertElement(link);
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