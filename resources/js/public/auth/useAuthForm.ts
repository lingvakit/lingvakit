import {useState} from 'react';
import {ApiError, post} from './api';

export function useAuthForm<T extends Record<string, string | boolean>>(
    initial: T,
    url: string,
    visibleFields: string[] = Object.keys(initial)
) {
    const [values, setValues] = useState<T>(initial);
    const [errors, setErrors] = useState<Record<string, string>>({});
    const [formError, setFormError] = useState<string | null>(null);
    const [processing, setProcessing] = useState(false);

    const setValue = <K extends keyof T>(key: K, value: T[K]) =>
        setValues((prev) => ({...prev, [key]: value}));

    /** Возвращает ответ сервера или null, если была ошибка (она уже в state). */
    async function submit<R = unknown>(extra: Record<string, unknown> = {}): Promise<R | null> {
        setProcessing(true);
        setErrors({});
        setFormError(null);
        try {
            return await post<R>(url, {...values, ...extra});
        } catch (e) {
            if (e instanceof ApiError && e.status === 422) {
                const mapped = Object.fromEntries(
                    Object.entries(e.errors).map(([k, v]) => [k, v[0]]),
                );
                setErrors(mapped);

                const orphan = Object.keys(mapped).find((k) => !visibleFields.includes(k));
                if (orphan) setFormError(mapped[orphan]);
                else if (Object.keys(mapped).length === 0) setFormError(e.message);
            } else if (e instanceof ApiError) {
                setFormError(e.status === 429
                    ? 'Слишком много попыток. Попробуйте чуть позже.'
                    : e.message);
            } else {
                setFormError('Нет соединения с сервером.');
            }
            return null;
        } finally {
            setProcessing(false);
        }
    }

    return {values, setValue, errors, formError, setFormError, processing, submit};
}