import { handleResponse } from "./utils/handleResponse";

type FetchJsonOptions = {
    method?: "GET" | "POST" | "PUT" | "PATCH" | "DELETE";
    signal?: AbortSignal;
    body?: unknown;
    headers?: HeadersInit;
};

function getXsrfHeader(): Record<string, string> {
    const token = document.cookie.match(/(?:^|; )XSRF-TOKEN=([^;]*)/)?.[1];
    return token ? { "X-XSRF-TOKEN": decodeURIComponent(token) } : {};
}

export async function fetchJson<T>(
    url: string,
    options: FetchJsonOptions = {},
): Promise<T> {
    const { method = "GET", body, headers, signal } = options;
    const hasBody = body !== undefined;
    const isMutation = method !== "GET";

    const response = await fetch(url, {
        method,
        credentials: "include",
        signal,
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
            ...(hasBody ? { "Content-Type": "application/json" } : {}),
            ...(isMutation ? getXsrfHeader() : {}),
            ...headers,
        },
        body: hasBody ? JSON.stringify(body) : undefined,
    });

    return handleResponse<T>(response);
}
