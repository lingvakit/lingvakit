export function isSafeMediaUrl(url: unknown): url is string {
    if (typeof url !== "string") return false;

    const normalized = url.replace(/[\u0000-\u001F\s]/g, "");
    if (normalized === "") return false;

    const hasScheme = /^[a-z][a-z0-9+.-]*:/i.test(normalized);
    return !hasScheme || /^https?:/i.test(normalized);
}
