import {CKEditor} from "@ckeditor/ckeditor5-react";
import {
    ClassicEditor,
    Essentials,
    Paragraph,
    Bold,
    Italic,
    Underline,
    Strikethrough,
    Heading,
    List,
    Link,
    BlockQuote,
    Image,
    ImageToolbar,
    ImageCaption,
    ImageStyle,
    ImageUpload,
    SimpleUploadAdapter,
    MediaEmbed,
    FontColor,
    FontBackgroundColor,
    Undo
} from 'ckeditor5';

type Props = {
    value: string;
    onChange: (value: string) => void;
};

export default function TextareaEditor({value, onChange}: Props) {
    return (
        <CKEditor
            editor={ClassicEditor}
            data={value}
            config={{
                licenseKey: 'GPL',
                plugins: [
                    Essentials,
                    Paragraph,
                    Bold,
                    Italic,
                    Underline,
                    Strikethrough,
                    Heading,
                    List,
                    Link,
                    BlockQuote,
                    Image,
                    ImageToolbar,
                    ImageCaption,
                    ImageStyle,
                    ImageUpload,
                    SimpleUploadAdapter,
                    MediaEmbed,
                    FontColor,
                    FontBackgroundColor,
                    Undo
                ],
                toolbar: [
                    'undo',
                    'redo',
                    '|',
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    '|',
                    'fontColor',
                    'fontBackgroundColor',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'link',
                    'blockQuote',
                    'insertImage',
                    'mediaEmbed'
                ],
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'toggleImageCaption',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side'
                    ]
                },
                simpleUpload: {
                    uploadUrl: '/api/editor/upload-image',
                    withCredentials: true,
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute('content') || ''
                    }
                },
            }}
            onChange={(_, editor) => {
                onChange(editor.getData())
            }}
        />
    );
}
