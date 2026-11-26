export type ValidationErrors = Record<string, string[]>;

export type FieldErrorValue = string | readonly string[] | null | undefined;

export function firstError(error: FieldErrorValue): string | undefined {
    const message = typeof error === "string" ? error : error?.[0];

    return message ? message : undefined;
}

export function controlClass(hasError: boolean, base = "form-control"): string {
    return hasError ? `${base} is-invalid` : base;
}
