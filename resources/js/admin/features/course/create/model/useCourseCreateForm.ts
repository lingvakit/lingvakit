import {type ChangeEvent, useState} from "react";
import { CourseCreateFormState } from "./types.ts";
import { MediaFile, MediaType } from "../../../../entities/media/model/types";
import {MediaTarget} from "../../../../shared/ui/modal/media/types";
import {MEDIA_FIELD_BY_TYPE} from "../../../../entities/media/model/constants";

const initialFormState: CourseCreateFormState = {
    title: "",
    description: "",
    difficultyLevel: "beginner",
    paidType: "free",
    isNew: true,
    isPublished: false,
    isAllowed: false,
    duration: 60,
    price: 0,
    salePrice: 0,
    categoryId: 1,
    media: {
        image: null,
        video: null,
        audio: null,
    },
};

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
        const { name, value, type } = e.target;

        const newValue =
            type === "checkbox"
                ? (e.target as HTMLInputElement).checked
                : numberFields.includes(name)
                    ? value === "" ? 0 : Number(value)
                    : value;

        setForm((prev) => ({
            ...prev,
            [name]: newValue,
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
        const field = MEDIA_FIELD_BY_TYPE[file.type];

        setForm((prev) => ({
            ...prev,
            media: {
                ...prev.media,
                [field]: file,
            },
        }));

        setIsMediaModalOpen(false);
    };

    const handleRemoveMediaFile = (type: MediaType): void => {
        const field = MEDIA_FIELD_BY_TYPE[type];

        setForm((prev) => ({
            ...prev,
            media: {
                ...prev.media,
                [field]: null,
            },
        }));
    };

    return {
        fields: form,
        handlers: {
            isMediaModalOpen,
            mediaTarget,
            mediaType,
            setDescription,
            changeInput: handleInputChange,
            openMediaModal: handleOpenMediaModal,
            closeMediaModal: handleCloseMediaModal,
            selectMediaFile: handleSelectMediaFile,
            removeMediaFile: handleRemoveMediaFile
        },
    };
}
