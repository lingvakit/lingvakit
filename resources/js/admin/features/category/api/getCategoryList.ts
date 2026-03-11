import type {Category} from "../types/category";

type CategoryListResponse = {
    data: Category[];
};

export async function getCategoryList() {
    const response = await fetch(`/react/api/categories`, {
        method: "GET",
        credentials: "include",
        headers: {
            Accept: "application/json",
        }
    });

    if (!response.ok) {
        const text = await response.text();
        throw new Error(`HTTP ${response.status}: ${text.slice(0, 200)}`);
    }

    const json: CategoryListResponse = await response.json();

    return json.data;
}
