import {MediaFile, MediaType} from "../../../../entities/media/model/types";
import {ChangeEvent, useState} from "react";
import {MEDIA_FIELD_BY_TYPE} from "../../../../entities/media/model/constants";
import {MediaTarget} from "../../../../shared/ui/modal/media/types";

type LessonFormValues = {
    title: string;
    duration: number;
    description?: string | null;
    mediaFiles: {
        audio: MediaFile | null;
        image: MediaFile | null;
        video: MediaFile | null;
    }
};

export function useLessonForm(initial?: Partial<LessonFormValues>) {
    const [form, setForm] = useState<LessonFormValues>({
        title: initial?.title ?? "",
        duration: initial?.duration ?? 0,
        description: initial?.description ?? "",
        mediaFiles: {
            audio: initial?.mediaFiles?.audio ?? null,
            image: initial?.mediaFiles?.image ?? null,
            video: initial?.mediaFiles?.video ?? null,
        }
    });

    const handleChange = (
        e: ChangeEvent<HTMLInputElement>
    ) => {
        const { name, value } = e.target;

        setForm(prev => ({
            ...prev,
            [name]: name === "duration" ? Number(value) : value
        }));
    };

    const setDescription = (
        value: string
    ) => {
        setForm(prev => ({
            ...prev,
            description: value
        }));
    };

    const setMediaFile = (
        file: MediaFile
    ): void => {
        setForm(prev => ({
            ...prev,
            mediaFiles: {
                ...prev.mediaFiles,
                [file.type]: file
            }
        }));
    };

    const handleRemoveMediaFile = (
        target: MediaTarget,
        type: MediaType
    ): void => {
        const field = MEDIA_FIELD_BY_TYPE[type];

        setForm((prev) => ({
            ...prev,
            mediaFiles: {
                ...prev.mediaFiles,
                [type]: null,
            },
        }));
    };

    return {
        fields: form,
        handlers: {
            handleChange,
            setDescription,
            setMediaFile,
            removeMediaFile: handleRemoveMediaFile
        }
    };
}
