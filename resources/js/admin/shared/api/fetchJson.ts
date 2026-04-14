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

    const data = await response.json().catch(() => null);

    if (!response.ok) {
        const error: any = new Error(data?.message || `HTTP ${response.status}`);

        error.status = response.status;
        error.errors = data?.errors || {};

        throw error;
    }

    return await data as Promise<T>;
}
