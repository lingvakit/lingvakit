import {type ChangeEvent, useState} from "react";
import {MediaFile, MediaType} from "../../media/types/mediaFile.ts";

type CourseCreateFormState = {
    title: string;
    description: string;
    difficultyLevel: string;
    duration: number;
    price: number;
    categoryId: number;
    media: {
        image: MediaFile | null;
        video: MediaFile | null;
        audio: MediaFile | null;
    };
};

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

    const handleOpenMediaModal = (type: MediaType): void => {
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
        mediaType,
        setDescription,
        handleInputChange,
        handleOpenMediaModal,
        handleCloseMediaModal,
        handleSelectMediaFile,
    };
}
