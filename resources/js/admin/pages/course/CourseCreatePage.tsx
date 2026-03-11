import React, {type ChangeEvent, type FormEvent, useState} from "react";
import {useCategoryList} from "../../features/category/hooks/useCategoryList";
import type {Category} from "../../features/category/types/category";
import {useCreateCourse} from "../../features/course/hooks/useCreateCourse";
import PageLayout from "../../layouts/PageLayout";

export default function CourseCreatePage() {
    const {categoryList, isLoading, error} = useCategoryList();
    const {
        create,
        isSaving,
        error: submitError,
    } = useCreateCourse();

    const [title, setTitle] = useState("");
    const [difficultyLevel, setDifficultyLevel] = useState("beginner");
    const [duration, setDuration] = useState(60);
    const [price, setPrice] = useState("");
    const [categoryId, setCategoryId] = useState("");

    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>
    ): Promise<void> => {
        e.preventDefault();

        await create({
            title: title.trim(),
            price,
            duration,
            difficultyLevel,
            categoryId: categoryId === "" ? 0 : Number(categoryId),
        });
    };

    const handleInputChange: React.ChangeEventHandler<HTMLInputElement> = (
        e: ChangeEvent<HTMLInputElement>
    ): void => {
        const { name, value } = e.target;

        if (name === "title") {
            setTitle(value);
        }

        if (name === "price") {
            setPrice(value);
        }

        if (name === "difficulty_level") {
            setDifficultyLevel(value);
        }

        if (name === "duration") {
            setDuration(value === "" ? 0 : Number(value));
        }
    };

    const handleChangeCategoryId: React.ChangeEventHandler<HTMLSelectElement> = (
        e: ChangeEvent<HTMLSelectElement>
    ): void => {
        setCategoryId(e.target.value);
    };

    if (isLoading) {
        return <>Загрузка категорий...</>;
    }

    if (error) {
        return <>Ошибка: {error}</>;
    }

    return (
        <PageLayout title="Новый курс">
            <form className="form-horizontal" onSubmit={handleSubmit}>
                <div className="row flex-row">
                    <div className="col-12">
                        <div className="widget has-shadow">
                            <div
                                className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
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
                                    <label className="col-lg-3 form-control-label">
                                        Наименование
                                        <span className="text-danger ml-2">*</span>
                                    </label>
                                    <div className="col-lg-9">
                                        <input
                                            type="text"
                                            name="title"
                                            className="form-control"
                                            placeholder="Наименование"
                                            value={title}
                                            onChange={handleInputChange}
                                        />
                                    </div>
                                </div>

                                <div className="form-group row d-flex align-items-center mb-5">
                                    <label className="col-lg-3 form-control-label">
                                        Уровень сложности
                                        <span className="text-danger ml-2">*</span>
                                    </label>
                                    <div className="col-lg-9">
                                        <input
                                            type="text"
                                            name="difficultyLevel"
                                            className="form-control"
                                            value={difficultyLevel}
                                            onChange={handleInputChange}
                                        />
                                    </div>
                                </div>

                                <div id="price" className="form-group row align-items-center mb-5 ">
                                    <label className="col-lg-3 form-control-label">Цена</label>
                                    <div className="col-lg-9">
                                        <input
                                            type="number"
                                            name="price"
                                            className="form-control"
                                            placeholder="100"
                                            value={price}
                                            onChange={handleInputChange}
                                        />
                                    </div>
                                </div>

                                <div className="form-group row align-items-center mb-5 ">
                                    <label className="col-lg-3 form-control-label">Длительность, мин</label>
                                    <div className="col-lg-9">
                                        <input
                                            type="number"
                                            name="duration"
                                            className="form-control"
                                            placeholder="100"
                                            value={duration}
                                            onChange={handleInputChange}
                                        />
                                    </div>
                                </div>

                                <div className="form-group row d-flex align-items-center mb-5">
                                    <label className="col-lg-3 form-control-label">Категория</label>
                                    <div className="col-lg-9">
                                        <div className="row">
                                            <div className="col-12">
                                                <select
                                                    id="category_select"
                                                    name="category_id"
                                                    className="custom-select form-control"
                                                    value={categoryId}
                                                    onChange={handleChangeCategoryId}
                                                >
                                                    <option value="" disabled>Категория</option>

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
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </PageLayout>
    );
}