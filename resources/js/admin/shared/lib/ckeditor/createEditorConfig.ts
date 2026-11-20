import {
    BlockQuote,
    Bold,
    Essentials,
    FontBackgroundColor,
    FontColor,
    Heading,
    Image,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    Italic,
    Link,
    List,
    MediaEmbed,
    Paragraph,
    SimpleUploadAdapter,
    Strikethrough,
    Underline,
} from "ckeditor5";
import type { EditorConfig } from "ckeditor5";
import ru from "ckeditor5/translations/ru.js";
import type { MediaType } from "../../../entities/media/model/types";
import type { MediaTarget } from "../../ui/modal/media/types";
import InsertMediaPlugin from "./plugins/InsertMediaPlugin/InsertMediaPlugin";

export type MediaModalOpener = (target: MediaTarget, type: MediaType) => void;

function getCsrfHeaders(): Record<string, string> {
    const meta = document.querySelector<HTMLMetaElement>(
        'meta[name="csrf-token"]',
    )?.content;
    if (meta) return { "X-CSRF-TOKEN": meta };

    const cookie = document.cookie.match(/(?:^|; )XSRF-TOKEN=([^;]*)/)?.[1];
    return cookie ? { "X-XSRF-TOKEN": decodeURIComponent(cookie) } : {};
}

export function createEditorConfig(
    openMediaModal: MediaModalOpener,
): EditorConfig {
    return {
        licenseKey: "GPL",
        language: "ru",
        translations: [ru],

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
            ImageResize,
            ImageUpload,
            SimpleUploadAdapter,
            MediaEmbed,
            FontColor,
            FontBackgroundColor,
            InsertMediaPlugin,
        ],

        toolbar: [
            "undo",
            "redo",
            "|",
            "heading",
            "|",
            "bold",
            "italic",
            "underline",
            "strikethrough",
            "|",
            "fontColor",
            "fontBackgroundColor",
            "|",
            "bulletedList",
            "numberedList",
            "|",
            "link",
            "blockQuote",
            "|",
            "insertMediaDropdown",
        ],

        image: {
            toolbar: [
                "imageTextAlternative",
                "toggleImageCaption",
                "imageStyle:inline",
                "imageStyle:block",
                "imageStyle:side",
            ],
        },

        simpleUpload: {
            uploadUrl: "/api/editor/upload-image",
            withCredentials: true,
            headers: getCsrfHeaders(),
        },

        mediaModal: { open: openMediaModal },
    };
}
