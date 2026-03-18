import {type ChangeEvent, useState} from "react";
import { CourseCreateFormState } from "./types.ts";
import { MediaFile, MediaType } from "../../../../entities/media/model/types.ts";
import {MediaTarget} from "../../../../shared/ui/modal/media/types.ts";

const initialFormState: CourseCreateFormState = {
    title: "",
    description: "",
    difficultyLevel: "beginner",
    duration: 60,
    price: 0,
    categoryId: 1,
    media: {
        image: null,
        video: null,
        audio: null,
    },
};

const mediaFieldByType = {
    image: "image",
    video: "video",
    audio: "audio",
} as const;

const numberFields = [
    "duration",
    "price",
    "categoryId",
    "image",
    "video",
];

export function useCourseCreateForm() {
    const [form, setForm] = useState<CourseCreateFormState>(initialFormState);
    const [isMediaModalOpen, setIsMediaModalOpen] = useState(false);
    const [mediaType, setMediaType] = useState<MediaType>("image");
    const [mediaTarget, setMediaTarget] = useState<MediaTarget>("form");

    const handleInputChange = (
        e: ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>
    ): void => {
        const { name, value } = e.target;

        setForm((prev) => ({
            ...prev,
            [name]: name === "duration" ? (value === "" ? 0 : Number(value)) : value,
            [name]: numberFields.includes(name)
                ? value === "" ? 0 : Number(value)
                : value,
        }));
    };

    const setDescription = (value: string): void => {
        setForm((prev) => ({
            ...prev,
            description: value,
        }));
    };

    const handleOpenMediaModal = (target: MediaTarget, type: MediaType): void => {
        setMediaTarget(target);
        setMediaType(type);
        setIsMediaModalOpen(true);
    };

    const handleCloseMediaModal = (): void => {
        setIsMediaModalOpen(false);
    };

    const handleSelectMediaFile = (file: MediaFile): void => {
        const field = mediaFieldByType[file.type];

        setForm((prev) => ({
            ...prev,
            media: {
                ...prev.media,
                [field]: file,
            },
        }));

        setIsMediaModalOpen(false);
    };

    return {
        title: form.title,
        description: form.description,
        difficultyLevel: form.difficultyLevel,
        duration: form.duration,
        price: form.price,
        categoryId: form.categoryId,
        image: form.media.image,
        video: form.media.video,
        audio: form.media.audio,
        isMediaModalOpen,
        mediaTarget,
        mediaType,
        setDescription,
        handleInputChange,
        handleOpenMediaModal,
        handleCloseMediaModal,
        handleSelectMediaFile,
    };
}
