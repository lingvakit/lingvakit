import {MediaFile} from "../../../../entities/media/model/types";
import {ChangeEvent, useState} from "react";

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
    ) => {
        setForm(prev => ({
            ...prev,
            mediaFiles: {
                ...prev.mediaFiles,
                [file.type]: file
            }
        }));
    };

    return {
        fields: form,
        handlers: {
            handleChange,
            setDescription,
            setMediaFile
        }
    };
}
