import type {CreateCoursePayload} from "../types/course";

type CreateCourseResponse = {
    data?: {
        id?: number;
    };
};

export async function createCourse(
    data: CreateCoursePayload
): Promise<CreateCourseResponse> {
    const response = await fetch("/react/api/courses", {
        method: "POST",
        credentials: "include",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    });

    if (!response.ok) {
        const text = await response.text();
        throw new Error(`HTTP ${response.status}: ${text.slice(0, 200)}`);
    }

    return response.json();
}