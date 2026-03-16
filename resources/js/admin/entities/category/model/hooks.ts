import { useEffect, useState } from "react";
import { Category, UseCategoryListResult } from "./types";
import { getCategoryList } from "../api/getCategoriesList";

export function useCategoryList(): UseCategoryListResult {
    const [categoryList, setCategoryList] = useState<Category[]>([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const load = async (): Promise<void> => {
            try {
                setIsLoading(true);
                setError(null);

                const categories: Category[] = await getCategoryList();
                setCategoryList(categories);
            } catch (error: unknown) {
                const message: string = error instanceof Error ? error.message : "Unknown error";

                setError(message);
                console.error("Не удалось загрузить категории", error);
            } finally {
                setIsLoading(false);
            }
        };

        void load();
    }, []);

    return {
        categoryList,
        isLoading,
        error
    };
}