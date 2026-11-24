import { useCallback, useEffect, useState } from "react";
import type { Category, UseCategoryListResult } from "./types";
import { getCategoryList } from "../api/getCategoriesList";
import { isValidationError } from "@admin/shared/api/utils/handleResponse";

export function useCategoryList(): UseCategoryListResult {
    const [categoryList, setCategoryList] = useState<Category[]>([]);
    const [isLoading, setIsLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);
    const [reloadToken, setReloadToken] = useState<number>(0);

    useEffect(() => {
        const controller = new AbortController();

        const load = async (): Promise<void> => {
            setIsLoading(true);
            setError(null);

            try {
                const categories = await getCategoryList(controller.signal);

                if (!Array.isArray(categories)) {
                    throw new Error("Некорректный формат ответа API категорий");
                }

                setCategoryList(categories);
            } catch (caught: unknown) {
                if (controller.signal.aborted) return;

                setCategoryList([]);
                setError(
                    caught instanceof Error
                        ? caught.message
                        : isValidationError(caught)
                          ? (caught.response.data?.message ??
                            "Ошибка валидации")
                          : "Unknown error",
                );
                console.error("Не удалось загрузить категории", caught);
            } finally {
                if (!controller.signal.aborted) setIsLoading(false);
            }
        };

        void load();

        return () => controller.abort();
    }, [reloadToken]);

    const reload = useCallback((): void => {
        setReloadToken((token) => token + 1);
    }, []);

    return {
        categoryList,
        isLoading,
        error,
        reload,
    };
}
