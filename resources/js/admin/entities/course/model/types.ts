import { Module } from "../../module/model/types";

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

export type CourseCreatePayload = {
    title: string;
    description: string;
    price: number;
    duration: number;
    difficultyLevel: string;
    paidType: string;
    isNew: boolean;
    isAllowed: boolean;
    categoryId: number;
    image?: number;
    video?: number;
};

export type UseCourseCreateResult = {
    create: (data: CourseCreatePayload) => Promise<void>;
    isSaving: boolean;
    error: string | null;
    fieldErrors: Record<string, string[]>;
};

export type CourseCreateResponse = {
    data?: {
        id?: number;
    };
};