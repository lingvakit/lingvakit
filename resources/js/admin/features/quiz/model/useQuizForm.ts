import { useCallback, useMemo, useState } from "react";
import type { ChangeEvent } from "react";
import type { MediaFile, MediaType } from "@admin/entities/media/model/types";
import { MEDIA_FIELD_BY_TYPE } from "@admin/entities/media/model/constants";
import type { MediaTarget } from "@admin/shared/ui/modal/media/types";

type MediaSlot = "audio" | "image" | "video";

export type QuizFormValues = {
    categoryId: number;
    title: string;
    description: string;
    timeLimit: number;
    passingScore: number;
    mediaFiles: Record<MediaSlot, MediaFile | null>;
};

export type QuizFormInitialValues = {
    categoryId?: number | null;
    title?: string | null;
    description?: string | null;
    timeLimit?: number | null;
    passingScore?: number | null;
    mediaFiles?: Partial<Record<MediaSlot, MediaFile | null>>;
};

const TEXT_FIELDS = ["title"] as const;
const NUMBER_FIELDS = ["categoryId", "timeLimit", "passingScore"] as const;

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

export function useQuizForm(initial?: QuizFormInitialValues) {
    const [form, setForm] = useState<QuizFormValues>(() => ({
        categoryId: initial?.categoryId ?? 0,
        title: initial?.title ?? "",
        description: initial?.description ?? "",
        timeLimit: initial?.timeLimit ?? 5,
        passingScore: initial?.passingScore ?? 50,
        mediaFiles: {
            audio: initial?.mediaFiles?.audio ?? null,
            image: initial?.mediaFiles?.image ?? null,
            video: initial?.mediaFiles?.video ?? null,
        },
    }));

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
