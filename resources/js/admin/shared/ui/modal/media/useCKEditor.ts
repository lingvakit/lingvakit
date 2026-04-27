import { Editor } from "@ckeditor/ckeditor5-core";
import {MediaFile, MediaType} from "../../../../entities/media/model/types";
import {useRef, useState} from "react";
import {MediaTarget} from "./types";

export function useCKEditor() {
    const editorRef = useRef<Editor | null>(null);
    const [isMediaModalOpen, setIsMediaModalOpen] = useState(false);
    const [mediaType, setMediaType] = useState<MediaType>("image");

    const setEditorRef = (editor: Editor) => {
        editorRef.current = editor;
    };

    const handleOpenMediaModal = (
        target: MediaTarget,
        type: MediaType
    ): void => {
        setMediaType(type);
        setIsMediaModalOpen(true);
    };

    const handleCloseMediaModal = (): void => {
        setIsMediaModalOpen(false);
    };

    const handleSelectMediaFile = (file: MediaFile) => {
        if (!editorRef.current) {
            return;
        }

        editorRef.current.execute('insertMedia', {
            type: file.type,
            src: file.url,
            alt: file.fileName,
            name: file.fileName,
        });

        setIsMediaModalOpen(false);
    };

    return {
        editorRef,
        isMediaModalOpen,
        mediaType,
        setEditorRef,
        handleSelectMediaFile,
        handleOpenMediaModal,
        handleCloseMediaModal,
    };
}