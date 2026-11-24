import { useCallback, useRef, useState } from "react";
import type { Editor } from "ckeditor5";
import type { MediaFile, MediaType } from "@admin/entities/media/model/types";
import type { MediaTarget } from "./types";
import type { InsertMediaPayload } from "@admin/shared/lib/ckeditor/plugins/InsertMediaPlugin/InsertMediaCommand";

export function useCKEditor() {
    const editorRef = useRef<Editor | null>(null);
    const [isMediaModalOpen, setIsMediaModalOpen] = useState(false);
    const [mediaType, setMediaType] = useState<MediaType>("image");
    const [mediaTarget, setMediaTarget] = useState<MediaTarget>("editor");

    const setEditorRef = useCallback((editor: Editor | null): void => {
        editorRef.current = editor;
    }, []);

    const handleOpenMediaModal = useCallback(
        (target: MediaTarget, type: MediaType): void => {
            setMediaTarget(target);
            setMediaType(type);
            setIsMediaModalOpen(true);
        },
        [],
    );

    const handleCloseMediaModal = useCallback((): void => {
        setIsMediaModalOpen(false);
    }, []);

    const handleSelectMediaFile = useCallback((file: MediaFile): void => {
        const editor = editorRef.current;

        if (!editor) {
            setIsMediaModalOpen(false);
            return;
        }

        const payload: InsertMediaPayload = {
            type: file.type,
            src: file.url,
            alt: file.fileName,
            name: file.fileName,
        };

        editor.editing.view.focus();
        editor.execute("insertMedia", payload);

        setIsMediaModalOpen(false);
    }, []);

    return {
        editorRef,
        isMediaModalOpen,
        mediaType,
        mediaTarget,
        setEditorRef,
        handleSelectMediaFile,
        handleOpenMediaModal,
        handleCloseMediaModal,
    };
}
