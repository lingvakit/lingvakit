import {handleResponse} from "./utils/handleResponse.ts";

type FetchMultipartOptions = {
    method?: "POST" | "PUT" | "PATCH";
    signal?: AbortSignal;
    body: FormData;
    headers?: HeadersInit;
};

export async function fetchMultipart<T>(
    url: string,
    options: FetchMultipartOptions
): Promise<T> {
    const { method = "POST", body, headers, signal } = options;

    const response = await fetch(url, {
        method,
        credentials: "include",
        signal,
        headers: {
            Accept: "application/json",
            ...headers,
        },
        body: body,
    });

    return handleResponse<T>(response);
}