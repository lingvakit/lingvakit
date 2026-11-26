import { useCallback, ChangeEvent, useState, useMemo } from "react";
import { MediaFile, MediaType } from "@admin/entities/media/model/types";
import { MEDIA_FIELD_BY_TYPE } from "@admin/entities/media/model/constants";
import { MediaTarget } from "@admin/shared/ui/modal/media/types";

type MediaSlot = "audio" | "image" | "video";

export type LessonFormValues = {
    title: string;
    duration: number;
    description?: string | null;
    mediaFiles: Record<MediaSlot, MediaFile | null>;
};

export type LessonFormInitialValues = {
    title?: string | null;
    description?: string | null;
    duration?: number | null;
    mediaFiles?: Partial<Record<MediaSlot, MediaFile | null>>;
};

const TEXT_FIELDS = ["title"] as const;
const NUMBER_FIELDS = ["duration"] as const;

function isOneOf<T extends string>(
    list: readonly T[],
    value: string,
): value is T {
    return (list as readonly string[]).includes(value);
}

function toNumber(raw: string): number {
    const parsed = Number(raw);
    return Number.isFinite(parsed) ? parsed : 0;
}

export function useLessonForm(initial?: Partial<LessonFormInitialValues>) {
    const [form, setForm] = useState<LessonFormValues>({
        title: initial?.title ?? "",
        duration: initial?.duration ?? 10,
        description: initial?.description ?? "",
        mediaFiles: {
            audio: initial?.mediaFiles?.audio ?? null,
            image: initial?.mediaFiles?.image ?? null,
            video: initial?.mediaFiles?.video ?? null,
        },
    });

    const changeText = useCallback(
        (e: ChangeEvent<HTMLInputElement | HTMLSelectElement>): void => {
            const { name, value } = e.target;
            if (!isOneOf(TEXT_FIELDS, name)) return;

            setForm((prev) => ({ ...prev, [name]: value }));
        },
        [],
    );

    const changeNumber = useCallback(
        (e: ChangeEvent<HTMLInputElement | HTMLSelectElement>): void => {
            const { name, value } = e.target;
            if (!isOneOf(NUMBER_FIELDS, name)) return;

            setForm((prev) => ({ ...prev, [name]: toNumber(value) }));
        },
        [],
    );

    const setDescription = useCallback((value: string): void => {
        setForm((prev) =>
            prev.description === value ? prev : { ...prev, description: value },
        );
    }, []);

    const setMediaFile = useCallback((file: MediaFile): void => {
        const slot = MEDIA_FIELD_BY_TYPE[file.type] as MediaSlot | undefined;
        if (!slot) return;

        setForm((prev) => ({
            ...prev,
            mediaFiles: { ...prev.mediaFiles, [slot]: file },
        }));
    }, []);

    const removeMediaFile = useCallback(
        (_target: MediaTarget, type: MediaType): void => {
            const slot = MEDIA_FIELD_BY_TYPE[type] as MediaSlot | undefined;
            if (!slot) return;

            setForm((prev) => ({
                ...prev,
                mediaFiles: { ...prev.mediaFiles, [slot]: null },
            }));
        },
        [],
    );

    const handlers = useMemo(
        () => ({
            changeText,
            changeNumber,
            setDescription,
            setMediaFile,
            removeMediaFile,
        }),
        [
            changeText,
            changeNumber,
            setDescription,
            setMediaFile,
            removeMediaFile,
        ],
    );

    return {
        fields: form,
        handlers,
    };
}
