export type Category = {
    id: number;
    title: string;
}

export type UseCategoryListResult = {
    categoryList: Category[];
    isLoading: boolean;
    error: string | null;
};