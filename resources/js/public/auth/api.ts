export class ApiError extends Error {
    constructor(
        public status: number,
        public errors: Record<string, string[]>,
        message: string,
    ) {
        super(message);
    }
}

const csrfToken = (): string =>
    document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content ?? '';

export async function post<T>(url: string, body: unknown): Promise<T> {
    const res = await fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(body),
    });

    const data = await res.json().catch(() => ({}));

    if (res.status === 419) {
        window.location.reload();
    }
    if (!res.ok) {
        throw new ApiError(res.status, data.errors ?? {}, data.message ?? 'Произошла ошибка');
    }
    return data as T;
}