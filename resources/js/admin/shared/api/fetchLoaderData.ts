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
    const response = await fetch(url, {
        method: "GET",
        credentials: "include",
        signal: options.signal,
        headers: {
            Accept: "application/json",
        },
    });

    if (!response.ok) {
        const text = await response.text().catch(() => "");
        throw new Response(text || "Request failed", {
            status: response.status,
        });
    }

    const json = (await response.json()) as ApiResponse<T>;

    if (json && typeof json === "object" && "data" in json) {
        return json.data as T;
    }

    return json as T;
}
