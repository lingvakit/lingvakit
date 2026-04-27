import { ClassicEditor } from "@ckeditor/ckeditor5-editor-classic";
import { Essentials } from "@ckeditor/ckeditor5-essentials";
import {CKEditor} from "@ckeditor/ckeditor5-react";
import {Paragraph} from "@ckeditor/ckeditor5-paragraph";
import {
    Bold,
    Italic,
    Strikethrough,
    Underline
} from "@ckeditor/ckeditor5-basic-styles";
import {Heading} from "@ckeditor/ckeditor5-heading";
import {List} from "@ckeditor/ckeditor5-list";
import {Link} from "@ckeditor/ckeditor5-link";
import {BlockQuote} from "@ckeditor/ckeditor5-block-quote";
import {
    Image,
    ImageCaption,
    ImageResize, ImageResizeButtons,
    ImageResizeEditing, ImageResizeHandles,
    ImageStyle,
    ImageToolbar,
    ImageUpload
} from "@ckeditor/ckeditor5-image";
import {SimpleUploadAdapter} from "@ckeditor/ckeditor5-upload";
import {MediaEmbed} from "@ckeditor/ckeditor5-media-embed";
import {FontBackgroundColor, FontColor} from "@ckeditor/ckeditor5-font";
import {Undo} from "@ckeditor/ckeditor5-undo";
import {MediaTarget} from "../modal/media/types";
import {MediaType} from "../../../entities/media/model/types";
import {Editor, EditorConfig} from "@ckeditor/ckeditor5-core";
import InsertMediaPlugin from "../../lib/ckeditor/plugins/InsertMediaPlugin/InsertMediaPlugin";
import { Widget } from '@ckeditor/ckeditor5-widget';
import { WidgetToolbarRepository } from '@ckeditor/ckeditor5-widget';


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
                    Widget,
                    WidgetToolbarRepository,
                    InsertMediaPlugin,
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
                    '|',
                    'insertMediaDropdown',
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
