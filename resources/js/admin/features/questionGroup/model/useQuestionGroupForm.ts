import {ChangeEvent, useState} from "react";
import {MediaFile} from "../../../entities/media/model/types";
import {FontSize} from "./types";

type FormValues = {
    title: string,
    description: string,
    meta: {
        fontSize: FontSize
    },
    mediaFiles: {
        audio: MediaFile | null,
        image: MediaFile | null,
        video: MediaFile | null,
    }
};

export function useQuestionGroupForm(initial?: Partial<FormValues>) {
    const [form, setForm] = useState<FormValues>({
        title: initial?.title ?? '',
        description: initial?.description ?? '',
        meta: {
            fontSize: initial?.meta?.fontSize ?? 'small'
        },
        mediaFiles: {
            audio: initial?.mediaFiles?.audio ?? null,
            image: initial?.mediaFiles?.image ?? null,
            video: initial?.mediaFiles?.video ?? null,
        }
    });

    const handleTextChange = (
        e: ChangeEvent<HTMLInputElement|HTMLTextAreaElement|HTMLSelectElement>
    ): void => {
        const { name, value } = e.target;

        setForm(prev => ({
            ...prev,
            [name]: String(value)
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

    const setMetaValue = <
        K extends keyof NonNullable<FormValues["meta"]>
    >(
        key: K,
        value: NonNullable<FormValues["meta"]>[K]
    ) => {
        setForm(prev => ({
            ...prev,
            meta: {
                ...prev.meta,
                [key]: value
            }
        }));
    };

    return {
        fields: form,
        handlers: {
            changeText: handleTextChange,
            setMediaFile,
            setMetaValue,
        }
    };
}
