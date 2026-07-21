type ApiResponse<T> = {
    data: T;
};

type LoaderJsonOptions = {
    signal?: AbortSignal;
};

export async function fetchLoaderData<T>(
    url: string,
    options: LoaderJsonOptions = {},
): Promise<T> {
    const res = await fetch(url, {
        method: "GET",
        credentials: "include",
        signal: options.signal,
        headers: {
            Accept: "application/json",
        },
    });

    if (!res.ok) {
        const text = await res.text().catch(() => "");
        throw new Response(text || "Request failed", { status: res.status });
    }

    const json = await res.json() as ApiResponse<T>;

    if (json && typeof json === 'object' && 'data' in json) {
        return json.data as T;
    }

    return json as T;
}