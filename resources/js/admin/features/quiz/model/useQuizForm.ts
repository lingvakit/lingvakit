import {ChangeEvent, useState} from "react";
import {MediaFile, MediaType} from "../../../entities/media/model/types";
import {MEDIA_FIELD_BY_TYPE} from "../../../entities/media/model/constants";

type FormValues = {
    categoryId: number;
    title: string;
    description?: string;
    timeLimit: number;
    passingScore: number;
    mediaFiles: {
        audio: MediaFile | null;
        image: MediaFile | null;
        video: MediaFile | null;
    };
};

export function useQuizForm(initial?: Partial<FormValues>) {
    const [form, setForm] = useState<FormValues>({
        categoryId: initial?.categoryId ?? 1,
        title: initial?.title ?? '',
        description: initial?.description ?? '',
        timeLimit: initial?.timeLimit ?? 5,
        passingScore: initial?.passingScore ?? 50,
        mediaFiles: {
            audio: initial?.mediaFiles?.audio ?? null,
            image: initial?.mediaFiles?.image ?? null,
            video: initial?.mediaFiles?.video ?? null,
        }
    });

    const handleTextChange = (
        e: ChangeEvent<HTMLInputElement|HTMLSelectElement>
    ): void => {
        const { name, value } = e.target;

        setForm(prev => ({
            ...prev,
            [name]: String(value)
        }));
    };

    const handleNumberChange = (
        e: ChangeEvent<HTMLInputElement|HTMLSelectElement>
    ): void => {
        const { name, value } = e.target;

        setForm(prev => ({
            ...prev,
            [name]: Number(value)
        }));
    };

    const setDescription = (
        value: string
    ): void => {
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

    const handleRemoveMediaFile = (type: MediaType): void => {
        const field = MEDIA_FIELD_BY_TYPE[type];

        setForm((prev) => ({
            ...prev,
            media: {
                ...prev.mediaFiles,
                [field]: null,
            },
        }));
    };

    return {
        fields: form,
        handlers: {
            changeText: handleTextChange,
            changeNumber: handleNumberChange,
            setDescription,
            setMediaFile,
            removeMediaFile: handleRemoveMediaFile
        }
    };
}