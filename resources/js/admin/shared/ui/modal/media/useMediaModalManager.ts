import {useState} from "react";
import {MediaFile, MediaType} from "../../../../entities/media/model/types";
import {MediaTarget} from "./types";

type UseMediaManagerOptions = {
    onCKEditorSelect?: (media: MediaFile) => void;
    onFormSelect?: (target: MediaTarget, media: MediaFile) => void;
};

export function useMediaModalManager(options?: UseMediaManagerOptions) {
    const [isOpen, setIsOpen] = useState(false);
    const [mediaType, setMediaType] = useState<MediaType>("image");
    const [mediaTarget, setMediaTarget] = useState<MediaTarget>("form");

    const open = (
        target: MediaTarget,
        type: MediaType
    ): void => {
        setMediaTarget(target);
        setMediaType(type);
        setIsOpen(true);
    };

    const close = () => {
        setIsOpen(false);
    };

    const handleSelect = (
        file: MediaFile
    ) => {
        if (mediaTarget === "editor") {
            options?.onCKEditorSelect?.(file);
        } else {
            options?.onFormSelect?.(mediaTarget, file);
        }

        close();
    };

    return {
        isOpen,
        mediaType,
        open,
        close,
        handleSelect,
    };
}
