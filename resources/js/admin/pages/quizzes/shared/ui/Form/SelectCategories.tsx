import { useMemo } from "react";
import type { Category } from "../../../../../entities/category/model/types";
import { useQuizForm } from "../../../../../features/quiz/model/useQuizForm";
import { SelectField } from "../../../../../shared/ui/form/SelectField";
import type { SelectOption } from "../../../../../shared/ui/form/SelectField";

type Props = {
    form: ReturnType<typeof useQuizForm>;
    categoriesList?: Category[];
    isLoading?: boolean;
    onCreateCategory?: () => void;
};

const EMPTY_CATEGORIES: Category[] = [];

export function SelectCategories({
    form,
    categoriesList = EMPTY_CATEGORIES,
    isLoading = false,
    onCreateCategory,
}: Props) {
    const options = useMemo<SelectOption[]>(
        () =>
            categoriesList.map((category) => ({
                value: category.id,
                label: category.title,
            })),
        [categoriesList],
    );

    return (
        <SelectField
            label="Категория"
            name="categoryId"
            value={form.fields.categoryId}
            options={options}
            onChange={form.handlers.changeNumber}
            isLoading={isLoading}
            isRequired
            placeholder="Выберите категорию"
        >
            {onCreateCategory && (
                <button
                    type="button"
                    className="btn btn-square btn-sm btn-primary mt-1"
                    onClick={onCreateCategory}
                >
                    Создать новую категорию
                </button>
            )}
        </SelectField>
    );
}
