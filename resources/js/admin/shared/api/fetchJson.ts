import {handleResponse} from "./utils/handleResponse";

type FetchJsonOptions = {
    method?: "GET" | "POST" | "PUT" | "PATCH" | "DELETE";
    signal?: AbortSignal;
    body?: unknown;
    headers?: HeadersInit;
};

export async function fetchJson<T>(
    url: string,
    options: FetchJsonOptions = {}
): Promise<T> {
    const { method = "GET", body, headers, signal } = options;

    const response = await fetch(url, {
        method,
        credentials: "include",
        signal,
        headers: {
            Accept: "application/json",
            ...(body ? { "Content-Type": "application/json" } : {}),
            ...headers,
        },
        body: body ? JSON.stringify(body) : undefined,
    });

    return handleResponse<T>(response);
}
