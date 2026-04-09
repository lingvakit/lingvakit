import {ChangeEvent, useState} from "react";
import {MediaFile} from "../../../../entities/media/model/types";
import {useMediaModalManager} from "../../../../shared/ui/modal/media/useMediaModalManager";

export function useLessonCreateForm() {
    const mediaModal = useMediaModalManager();

    const [title, setTitle] = useState<string>("");
    const [description, setDescription] = useState<string>("");
    const [duration, setDuration] = useState<number>(0);
    const [mediaFiles, setMediaFiles] = useState<{
        audio: MediaFile|null,
        image: MediaFile|null,
        video: MediaFile|null,
    }>({
        audio: null,
        image: null,
        video: null,
    });

    const handleTitleChange = (
        e: ChangeEvent<HTMLInputElement>
    ): void => {
        setTitle(e.target.value);
    };

    const handleDescriptionChange = (
        value: string
    ): void => {
        setDescription(value);
    };

    const handleDurationChange = (
        e: ChangeEvent<HTMLInputElement>
    ): void => {
        setDuration(
            e.target.value === "" ? 0 : Number(e.target.value)
        );
    };

    const handleSelectMediaFile = (
        file: MediaFile
    ): void => {
        if (mediaModal.mediaType) {
            setMediaFiles(prev => ({
                ...prev,
                [mediaModal.mediaType]: file
            }))
        }

        mediaModal.close();
    };

    return {
        fields: {
            title,
            description,
            duration,
            mediaFiles,
        },
        handlers: {
            titleChange: handleTitleChange,
            descriptionChange: handleDescriptionChange,
            durationChange: handleDurationChange,
            selectMediaFile: handleSelectMediaFile
        }
    };
}
