import React, {useEffect, useState} from "react";
import {Link, useParams} from "react-router-dom";
import parse from "html-react-parser";

export default function CourseShowPage() {
    const {courseId} = useParams();
    const [course, setCourse] = useState(null);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        fetch(`/api/v1/courses/${courseId}`)
            .then(res => res.json())
            .then(data => {

                console.log(data);

                setCourse(data);
                setLoading(false);
            });
    }, [courseId]);

    if (loading) {
        return <div>Загрузка...</div>
    }

    if (!course) {
        return <div>Курс не найден</div>;
    }

    const {
        title,
        description,
        imageUrl,
        duration,
        category,
        language,
        difficultyLevel,
        publishDate,
        price,
        author,
        modules
    } = course;

    return (
        <div className="row">
            <div className="col-xl-12">
                <div className="widget has-shadow">
                    <div
                        className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                        <h4>{title}</h4>
                        <div className="form-group">
                            <a href="" type="button" className="btn btn-primary mr-1 mb-2">
                                Редактирование
                            </a>
                        </div>
                    </div>
                    <div className="widget-body">
                        <div className="row flex-row">
                            <div className="col-xl-3">
                                <div className="about-infos d-flex flex-column mb-3">
                                    <div className="about-image">
                                        <img src={imageUrl} alt=""/>
                                    </div>
                                </div>
                            </div>
                            <div className="col-xl-9">
                                <div className="about-infos d-flex flex-column mb-3">
                                    <div className="about-title">
                                        <h5>Автор:</h5>
                                    </div>
                                    <div className="about-text">
                                        {author.fullName}
                                    </div>
                                </div>

                                <div className="about-infos d-flex flex-column mb-3">
                                    <div className="about-title">
                                        <h5>Дата публикации:</h5>
                                    </div>
                                    <div className="about-text">
                                        {publishDate}
                                    </div>
                                </div>

                                <div className="about-infos d-flex flex-column mb-3">
                                    <div className="about-title">
                                        <h5>Описание:</h5>
                                    </div>
                                    <div className="about-text">
                                        {parse(description)}
                                    </div>
                                </div>

                                <div className="about-infos d-flex mb-4">
                                    {language ? (
                                        <button type="button" className="btn btn-outline-primary btn-sm mr-3">
                                            {language}
                                        </button>
                                    ) : ""}

                                    {category ? (
                                        <button type="button" className="btn btn-outline-info btn-sm mr-3">
                                            {category}
                                        </button>
                                    ) : ""}

                                    <button type="button" className="btn btn-outline-danger btn-sm mr-3">
                                        {difficultyLevel}
                                    </button>
                                </div>

                                <div className="about-infos d-flex flex-column mb-3">
                                    <div className="about-title">
                                        <h5>Длительность курса:</h5>
                                    </div>
                                    <div className="about-text">
                                        {duration}
                                    </div>
                                </div>

                                <div className="about-infos d-flex flex-column mb-3">
                                    <div className="about-title">
                                        <h5>Стоимость курса:</h5>
                                    </div>
                                    <div className="about-text">
                                        {parse(price)}
                                    </div>
                                </div>

                                <div className="about-infos d-flex flex-column mb-3">
                                    <div className="text-left">
                                        <Link to="#" className="btn btn-warning btn-sm mr-1 mb-2">Студенты</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="col-xl-12">
                <div className="widget has-shadow">
                    <div
                        className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                        <h4>План курса</h4>
                        <button type="button" className="btn btn-primary mr-1 mb-2" data-toggle="modal"
                                data-target="#modal-stage">
                            Добавить модуль
                        </button>
                    </div>
                    <div className="widget-body">
                        {modules.map((module, index) => (
                            <div key={index} className="mt-2 mb-2">
                                <div
                                    className="d-flex justify-content-between align-items-center pl-3 pr-3 text-primary header w-100"
                                    style={{backgroundColor: "#dedbe2"}}
                                >
                                    <h4 className="mb-0">{module.title}</h4>
                                    <div className="td-actions text-right d-flex justify-content-end">
                                        <div className="actions dark d-inline-block">
                                            <div className="dropdown">
                                                <button type="button"
                                                        data-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false"
                                                        className="dropdown-toggle"
                                                ><i className="la la-plus edit"></i>
                                                </button>
                                                <div className="dropdown-menu">
                                                    <Link to="#" className="dropdown-item">
                                                        <i className="la la-plus"></i>Добавить урок
                                                    </Link>

                                                    <Link
                                                        to={`/courses/${courseId}/modules/${module.id}/quizzes/create`}
                                                        className="dropdown-item"
                                                    >
                                                        <i className="la la-plus"></i>Добавить тест
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button">
                                            <i className="la la-edit edit"></i>
                                        </button>
                                    </div>
                                </div>
                                {module.topics.map((topic, index) => (
                                    <div key={index}
                                         className="stage-topic d-flex justify-content-between align-items-center mt-3 mb-3 ui-sortable-handle">
                                        <div className="col-xl-2">
                                            <div className="table-img">
                                                <img src={topic.imageUrl} width="100" alt=""/>
                                            </div>
                                        </div>
                                        <div className="col-xl-2">{topic.type}</div>
                                        <div className="col-xl-2">{topic.title}</div>
                                        <div className="col-xl-2">{topic.timeLimit}</div>
                                        <div className="col-xl-2">Actions</div>
                                    </div>
                                ))}
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    )
}