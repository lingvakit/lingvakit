import { MediaFile } from "../../../../entities/media/model/types";

export type CourseCreateFormState = {
    title: string;
    description: string;
    difficultyLevel: string;
    paidType: string;
    isNew: boolean;
    isPublished: boolean;
    isAllowed: boolean;
    duration: number;
    price: number;
    salePrice: number;
    categoryId: number;
    media: {
        image: MediaFile | null;
        video: MediaFile | null;
        audio: MediaFile | null;
    };
};