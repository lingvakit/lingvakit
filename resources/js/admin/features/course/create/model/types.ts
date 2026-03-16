import { MediaFile } from "../../../../entities/media/model/types";

export type CourseCreateFormState = {
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