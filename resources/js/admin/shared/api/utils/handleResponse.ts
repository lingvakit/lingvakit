import { ApiError } from "../errors/ApiError";

export type ValidationErrorShape = {
    response: {
        status: 422;
        data: { message?: string; errors?: Record<string, string[]> } | null;
    };
};

export function isValidationError(
    error: unknown,
): error is ValidationErrorShape {
    return (
        typeof error === "object" &&
        error !== null &&
        "response" in error &&
        (error as ValidationErrorShape).response?.status === 422
    );
}

export async function handleResponse<T>(response: Response): Promise<T> {
    const json = await response.json().catch(() => null);

    if (!response.ok) {
        if (response.status === 422) {
            throw {
                response: { status: 422, data: json },
            } satisfies ValidationErrorShape;
        }

        throw new ApiError(
            json?.message || `HTTP ${response.status}`,
            response.status,
            json?.errors || {},
        );
    }

    if (json && typeof json === "object" && "data" in json) {
        return ("meta" in json ? json : json.data) as T;
    }

    return json as T;
}
