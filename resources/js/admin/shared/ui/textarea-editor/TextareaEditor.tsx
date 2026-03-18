import type {Editor, EditorConfig} from "ckeditor5";
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
    ImageResize,
    ImageResizeEditing,
    ImageResizeHandles,
    ImageResizeButtons,
    ImageUpload,
    SimpleUploadAdapter,
    MediaEmbed,
    FontColor,
    FontBackgroundColor,
    Undo
} from 'ckeditor5';
import {MediaType} from "../../../entities/media/model/types.ts";
import InsertMediaButton from "../../lib/ckeditor/plugins/InsertMediaButton.ts";
import InsertMediaPlugin from "../../lib/ckeditor/plugins/InsertMediaPlugin.ts";
import {MediaTarget} from "../modal/media/types.ts";

type ExtendedEditorConfig = EditorConfig & {
    mediaModal?: {
        open: (target: MediaTarget, type: MediaType) => void;
    };
};

type Props = {
    value: string;
    onChange: (value: string) => void;
    onOpenMediaModal: (target: MediaTarget, type: MediaType) => void;
    setEditorRef: (editor: Editor) => void;
};

export default function TextareaEditor({value, onChange, onOpenMediaModal, setEditorRef}: Props) {
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
                    ImageResize,
                    ImageResizeEditing,
                    ImageResizeHandles,
                    ImageResizeButtons,
                    SimpleUploadAdapter,
                    MediaEmbed,
                    FontColor,
                    FontBackgroundColor,
                    Undo,
                    InsertMediaPlugin,
                    InsertMediaButton,
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
                    'mediaEmbed',
                    '|',
                    'insertMediaButton',
                ],
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'toggleImageCaption',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side',
                    ],
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

                mediaModal: {
                    open: (target: MediaTarget, type: MediaType) => {
                        onOpenMediaModal(target, type);
                    }
                },
            } as unknown as ExtendedEditorConfig}
            onReady={(editor) => {
                setEditorRef(editor);
            }}
            onChange={(_, editor) => {
                onChange(editor.getData())
            }}
        />
    );
}
