import {Category} from "../../../../../../entities/category/model/types";
import {useQuizForm} from "../../../../../../features/quiz/model/useQuizForm";

type Props = {
    form: ReturnType<typeof useQuizForm>;
    categoriesList: Category[];
};

export function SelectCategories({form, categoriesList}: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label className="col-lg-3 form-control-label">Категория</label>
            <div className="col-lg-9">
                <select
                    name="categoryId"
                    className="custom-select form-control"
                    value={form.fields.categoryId}
                    onChange={form.handlers.changeNumber}
                >
                    {categoriesList.map((category: Category) => (
                        <option
                            key={category.id}
                            value={category.id}
                        >{category.title}</option>
                    ))}
                </select>

                <button
                    type="button"
                    className="btn btn-square btn-sm btn-primary mt-1"
                >Создать новую категорию</button>
            </div>
        </div>
    );
}