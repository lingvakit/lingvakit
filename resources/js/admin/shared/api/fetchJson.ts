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

    if (!response.ok) {
        const text = await response.text();
        throw new Error(`HTTP ${response.status}: ${text.slice(0, 200)}`);
    }

    return await response.json() as Promise<T>;
}
