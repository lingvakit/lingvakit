import type {Module} from "./module";

export type Course = {
    id: number;
    title: string;
    imageUrl: string;
    price: number;
    duration: number;
    createdAt: string;
    description?: string | null;
    author?: string | null;
    modules?: Module[] | null;
};

export type CreateCoursePayload = {
    title: string;
    description: string;
    price: number;
    duration: number;
    difficultyLevel: string;
    categoryId: number;
    image?: number;
    video?: number;
};