import {ApiError} from "../errors/ApiError";

export async function handleResponse<T>(response: Response): Promise<T> {
    const json = await response.json().catch(() => null);

    if (!response.ok) {
        if (response.status === 422) {
            throw {
                response: {
                    status: 422,
                    data: json
                }
            };
        }

        throw new ApiError(
            json?.message || `HTTP ${response.status}`,
            response.status,
            json?.errors || {}
        );
    }

    if (json && typeof json === 'object' && 'data' in json) {
        if ('meta' in json) {
            return json as T;
        }

        return json.data as T;
    }

    return json as T;
}
