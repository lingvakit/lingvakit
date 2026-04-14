import { Editor } from "ckeditor5";
import {MediaFile, MediaType} from "../../../../entities/media/model/types.ts";
import {useRef, useState} from "react";

export function useCKEditor() {
    const editorRef = useRef<Editor | null>(null);
    const [isMediaModalOpen, setIsMediaModalOpen] = useState(false);
    const [mediaType, setMediaType] = useState<MediaType>("image");

    const setEditorRef = (editor: Editor) => {
        editorRef.current = editor;
    };

    const handleOpenMediaModal = (type: MediaType): void => {
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

        editorRef.current.execute("insertImage", {
            source: file.url
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