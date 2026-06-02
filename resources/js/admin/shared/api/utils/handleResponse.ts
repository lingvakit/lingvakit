import {ApiError} from "../errors/ApiError";

export async function handleResponse<T>(response: Response): Promise<T> {
    const data = await response.json().catch(() => null);

    if (!response.ok) {
        throw new ApiError(
            data?.message || `HTTP ${response.status}`,
            response.status,
            data?.errors || {}
        );
    }

    return data as T;
}
