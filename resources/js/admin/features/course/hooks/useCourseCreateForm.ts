import React, {type ChangeEvent, useState} from "react";
import {MediaFile, MediaType} from "../../../shared/types/media";

export function useCourseCreateForm() {
    const [title, setTitle] = useState("");
    const [description, setDescription] = useState("");
    const [difficultyLevel, setDifficultyLevel] = useState("beginner");
    const [duration, setDuration] = useState(60);
    const [price, setPrice] = useState("");
    const [categoryId, setCategoryId] = useState("");

    const [isMediaModalOpen, setIsMediaModalOpen] = useState(false);
    const [mediaType, setMediaType] = useState<MediaType>("image");

    const [imageId, setImageId] = useState<number | null>(null);
    const [videoId, setVideoId] = useState<number | null>(null);
    const [audioId, setAudioId] = useState<number | null>(null);

    const handleInputChange = (
        e: ChangeEvent<HTMLInputElement>
    ): void => {
        const {name, value} = e.target;

        if (name === "title") {
            setTitle(value);
        }

        if (name === "price") {
            setPrice(value);
        }

        if (name === "difficulty_level") {
            setDifficultyLevel(value);
        }

        if (name === "duration") {
            setDuration(value === "" ? 0 : Number(value));
        }
    };

    const handleChangeCategoryId = (
        e: ChangeEvent<HTMLSelectElement>
    ): void => {
        setCategoryId(e.target.value);
    };

    const handleOpenMediaModal = (type: MediaType): void => {
        setMediaType(type);
        setIsMediaModalOpen(true);
    };

    const handleCloseMediaModal = (): void => {
        setIsMediaModalOpen(false);
    };

    const handleSelectMediaFile = (file: MediaFile): void => {
        if (file.type === "image") {
            setImageId(file.id);
        }

        if (file.type === "video") {
            setVideoId(file.id);
        }

        if (file.type === "audio") {
            setAudioId(file.id);
        }

        setIsMediaModalOpen(false);
    };

    return {
        title,
        description,
        difficultyLevel,
        duration,
        price,
        categoryId,
        imageId,
        videoId,
        audioId,
        isMediaModalOpen,
        mediaType,

        setDescription,

        handleInputChange,
        handleChangeCategoryId,
        handleOpenMediaModal,
        handleCloseMediaModal,
        handleSelectMediaFile
    };
}