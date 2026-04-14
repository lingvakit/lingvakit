import {FormEvent} from "react";
import { Category } from "../../../../../entities/category/model/types";
import { useCourseCreateForm } from "../../../../../features/course/create/model/useCourseCreateForm";
import TextareaEditor from "../../../../../shared/ui/textarea-editor/TextareaEditor";
import InputMedia from "../../../../../shared/ui/input-media/InputMedia";
import SelectDifficulty from "../../../../../shared/ui/select-difficulty/SelectDifficulty";
import {useCKEditor} from "../../../../../shared/ui/modal/media/useCKEditor";
import SelectPaidTypeField from "../../../../../shared/ui/select-paid-type/SelectPaidTypeField";
import IsNewCheckbox from "./Form/IsNewCheckbox.tsx";
import IsPublishedCheckbox from "./Form/IsPublishedCheckbox";

type Props = {
    categoryList: Category[];
    submitError: string | null;
    isSaving: boolean;
    form: ReturnType<typeof useCourseCreateForm>;
    onSubmit: () => Promise<void>;
    ck: ReturnType<typeof useCKEditor>;
    fieldErrors?: Record<string, string[]>;
};

export default function CourseForm(
    {
        categoryList,
        submitError,
        isSaving,
        form,
        onSubmit,
        ck,
        fieldErrors,
    }: Props) {
    const handleSubmit = async (e: FormEvent<HTMLFormElement>): Promise<void> => {
        e.preventDefault();
        await onSubmit();
    };

    return (
        <form className="form-horizontal" onSubmit={handleSubmit}>
            <div className="row flex-row">
                <div className="col-12">
                    <div className="widget has-shadow">
                        <div className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                            <h4>Данные о курсе</h4>

                            <div className="text-right">
                                <button
                                    className="btn btn-primary"
                                    type="submit"
                                    disabled={isSaving}
                                >
                                    {isSaving ? "Сохранение..." : "Сохранить"}
                                </button>
                            </div>
                        </div>

                        <div className="widget-body">
                            {submitError && (
                                <div className="alert alert-danger" role="alert">
                                    {submitError}
                                </div>
                            )}

                            <div className="form-group row d-flex align-items-center mb-5">
                                <label className="col-lg-3 form-control-label">Категория</label>
                                <div className="col-lg-9">
                                    <div className="row">
                                        <div className="col-12">
                                            <select
                                                id="category_select"
                                                name="categoryId"
                                                className="custom-select form-control"
                                                value={form.categoryId}
                                                onChange={form.handleInputChange}
                                            >
                                                <option value="" disabled>
                                                    Категория
                                                </option>

                                                {categoryList.map((category: Category) => (
                                                    <option key={category.id} value={category.id}>
                                                        {category.title}
                                                    </option>
                                                ))}

                                                <option value="0">Новая категория</option>
                                            </select>
                                        </div>

                                        <div id="new_category" className="col-12 mt-3">
                                            <input
                                                type="text"
                                                name="category"
                                                className="form-control"
                                                placeholder="Новая категория"
                                                value=""
                                                disabled
                                                onChange={() => { }}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="form-group row d-flex align-items-center mb-5">
                                <label className="col-lg-3 form-control-label">
                                    Заголовок
                                    <span className="text-danger ml-2">*</span>
                                </label>
                                <div className="col-lg-9">
                                    <input
                                        type="text"
                                        name="title"
                                        className="form-control"
                                        placeholder="Наименование"
                                        value={form.title}
                                        onChange={form.handleInputChange}
                                    />

                                    {fieldErrors?.title && (
                                        <small className="text-danger">
                                            {fieldErrors.title[0]}
                                        </small>
                                    )}
                                </div>
                            </div>

                            <div className="form-group row d-flex align-items-center mb-5">
                                <label className="col-lg-3 form-control-label">Описание</label>
                                <div className="col-lg-9">
                                    <TextareaEditor
                                        value={form.description}
                                        onChange={form.setDescription}
                                        onOpenMediaModal={form.handleOpenMediaModal}
                                        setEditorRef={ck.setEditorRef}
                                    />
                                </div>
                            </div>

                            <InputMedia
                                image={form.image}
                                video={form.video}
                                audio={form.audio}
                                onOpenMediaModal={form.handleOpenMediaModal}
                            />

                            <SelectDifficulty
                                value={form.difficultyLevel}
                                onChange={form.handleInputChange}
                            />

                            <SelectPaidTypeField
                                value={form.paidType}
                                onChange={form.handleInputChange}
                            />

                            {form.paidType === "paid" && (
                                <>
                                    <div id="price" className="form-group row align-items-center mb-5">
                                        <label className="col-lg-3 form-control-label">Цена</label>
                                        <div className="col-lg-9">
                                            <input
                                                type="number"
                                                name="price"
                                                className="form-control"
                                                placeholder="100"
                                                value={form.price}
                                                onChange={form.handleInputChange}
                                            />
                                        </div>
                                    </div>

                                    <div id="salePrice" className="form-group row align-items-center mb-5">
                                        <label className="col-lg-3 form-control-label">Акционная цена</label>
                                        <div className="col-lg-9">
                                            <input
                                                type="number"
                                                name="salePrice"
                                                className="form-control"
                                                placeholder="100"
                                                value={form.salePrice}
                                                onChange={form.handleInputChange}
                                            />
                                        </div>
                                    </div>
                                </>
                            )}

                            <IsNewCheckbox
                                value={form.isNew}
                                onChange={form.handleInputChange}
                            />

                            <IsPublishedCheckbox
                                value={form.isPublished}
                                onChange={form.handleInputChange}
                            />

                            <div className="form-group row align-items-center mb-5">
                                <label className="col-lg-3 form-control-label">
                                    Длительность, мин
                                </label>
                                <div className="col-lg-9">
                                    <input
                                        type="number"
                                        name="duration"
                                        className="form-control"
                                        placeholder="100"
                                        value={form.duration}
                                        onChange={form.handleInputChange}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    );
}
