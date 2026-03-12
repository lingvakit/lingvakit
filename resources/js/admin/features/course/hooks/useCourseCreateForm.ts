import {type ChangeEvent, useState} from "react";
import {MediaFile, MediaType} from "../../media/types/mediaFile.ts";

type CourseCreateFormState = {
    title: string;
    description: string;
    difficultyLevel: string;
    duration: number;
    price: string;
    categoryId: string;
    media: {
        imageId: number | null;
        videoId: number | null;
        audioId: number | null;
    };
};

const initialFormState: CourseCreateFormState = {
    title: "",
    description: "",
    difficultyLevel: "beginner",
    duration: 60,
    price: "",
    categoryId: "",
    media: {
        imageId: null,
        videoId: null,
        audioId: null,
    },
};

const mediaFieldByType = {
    image: "imageId",
    video: "videoId",
    audio: "audioId",
} as const;

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
                [field]: file.id,
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
        imageId: form.media.imageId,
        videoId: form.media.videoId,
        audioId: form.media.audioId,
        isMediaModalOpen,
        mediaType,
        setDescription,
        handleInputChange,
        handleOpenMediaModal,
        handleCloseMediaModal,
        handleSelectMediaFile,
    };
}
