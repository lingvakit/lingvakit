import React, {useState} from "react";
import {useForm} from "react-hook-form";
import {useParams} from "react-router-dom";
import Editor from "./components/Editor.jsx";

export default function QuizCreatePage() {
    const [description, setDescription] = useState("");

    const {
        courseId,
        moduleId
    } = useParams();

    const {
        register,
        handleSubmit,
        formState: {errors}
    } = useForm();


    async function onSubmit(data) {
        const response = await fetch(`/api/v1/courses/${courseId}/modules/${moduleId}/create`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });
    }

    return (
        <form className="form-horizontal" onSubmit={handleSubmit(onSubmit)}>
            <div className="row flex-row">
                <div className="col-12">
                    <div className="widget has-shadow">
                        <div className="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Форма создания теста</h4>
                        </div>
                        <div className="widget-body">
                            <div className="form-group row d-flex align-items-center mb-5">
                                <label className="col-lg-3 form-control-label">
                                    Категория
                                </label>
                                <div className="col-lg-9">
                                    <div className="row">
                                        <div className="col-lg-6">
                                            <select id="category_select" name="category_id"
                                                    className="custom-select form-control">
                                                <option value="">cat</option>
                                                <option value="1">___</option>
                                                <option value="0">0</option>
                                            </select>
                                            <div className="invalid-feedback">asdsa</div>
                                        </div>
                                        <div id="new_category" className="col-lg-6">
                                            <input type="text" name="category" className="form-control"
                                                   placeholder="adsfdsf"
                                                   value="asdf" disabled/>
                                            <div className="invalid-feedback">asdf</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Title */}
                            <div className="form-group row d-flex align-items-center mb-5">
                                <label className="col-lg-3 form-control-label">Название теста<span
                                    className="text-danger ml-2">*</span></label>
                                <div className="col-lg-9">
                                    <input
                                        type="text"
                                        className="form-control"
                                        placeholder="Тест по китайскому языку ..."
                                        {...register("title", {required: "Введите название теста", minLength: 4})}
                                    />
                                    {errors.title && (
                                        <div className="invalid-feedback">{errors.title.message}</div>
                                    )}
                                </div>
                            </div>

                            <div className="form-group row d-flex align-items-center mb-5">
                                <label className="col-lg-3 form-control-label">Описание<span
                                    className="text-danger ml-2">*</span></label>
                                <div className="col-lg-9">
                                    <Editor value={description} onChange={setDescription} name="description" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="text-right">
                <button className="btn btn-gradient-01" type="submit">Создать</button>
                <button className="btn btn-shadow" type="reset">Отмена</button>
            </div>
        </form>
    )
}