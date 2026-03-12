type QueryValue = string | number | boolean | null | undefined;

export function buildQuery(
    params: Record<string, QueryValue>
): string {
    const searchParams = new URLSearchParams();

    Object.entries(params).forEach(([key, value]) => {
        if (value === null || value === undefined) {
            return;
        }

        if (typeof value === "string") {
            const trimmedString = value.trim();
            if (!trimmedString) {
                return;
            }

            searchParams.set(key, trimmedString);
            return;
        }

        searchParams.set(key, String(value));
    });

    return searchParams.toString();
}
