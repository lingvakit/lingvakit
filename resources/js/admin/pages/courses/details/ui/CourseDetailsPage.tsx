import {Link, useLoaderData} from "react-router-dom";
import DOMPurify from "dompurify";
import {Course} from "../../../../entities/course/model/types";
import PageLayout from "../../../../widgets/layout/PageLayout";
import {formatDate, formatDurationToText} from "../../../../shared/lib/converter";
import {useState} from "react";
import {ModuleFormModal} from "../../../../shared/ui/modal/module/ModuleFormModal";
import {Module} from "../../../../entities/module/model/types";
import {Lesson} from "../../../../entities/lesson/model/types.ts";
import {useDeleteLesson} from "../../../../entities/lesson/model/hooks";

export default function CourseShowPage() {
    const course = useLoaderData() as Course;
    const {execute} = useDeleteLesson();

    const [isModuleModalOpen, setIsModuleModalOpen] = useState(false);
    const [modules, setModules] = useState(course.modules ?? []);

    const handleOpenModuleModal = (): void => {
        setIsModuleModalOpen(true);
    };

    const handleCloseModuleModal = (): void => {
        setIsModuleModalOpen(false);
    };

    const handleModuleCreated = (
        newModule: Module | null
    ): void => {
        if (!newModule) return;

        setModules(prev => [...prev, newModule])
    };

    const handleDeleteLesson = async (
        lesson: Lesson | null | undefined
    ): Promise<void> => {
        if (!lesson) return;
        await execute(lesson.id)

        setModules(prev =>
            prev.map(module => ({
                ...module,
                topics: module.topics?.filter(
                    topic => topic.lesson?.id !== lesson.id
                )
            }))
        );
    }

    return (
        <PageLayout title={course.title}>
            <div className="row flex-row">
                <div className="col-12">
                    <div className="widget has-shadow">
                        <div
                            className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                            <h4>Информация о курсе</h4>

                            <div className="form-group">
                                <a href="#" type="button"
                                   className="btn btn-primary mr-1 mb-2">Редактировать</a>
                                <a href="#" type="button"
                                   className="btn btn-warning mr-1 mb-2">Заблокировать</a>
                                <a href="#" type="button"
                                   className="btn btn-danger mr-1 mb-2">Удалить</a>
                            </div>
                        </div>

                        <div className="widget-body">
                            <div className="row flex-row">
                                <div className="col-xl-3">
                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="about-image">
                                            <img src={course.imageUrl} alt={course.title}/>
                                        </div>
                                    </div>
                                </div>

                                <div className="col-xl-9">
                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="about-title">
                                            <h5>Автор курса:</h5>
                                        </div>
                                        <div className="about-text">{course.author}</div>
                                    </div>

                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="about-title">
                                            <h5>Дата публикации:</h5>
                                        </div>
                                        <div className="about-text">{formatDate(course.createdAt)}</div>
                                    </div>

                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="about-title">
                                            <h5>Наименование:</h5>
                                        </div>
                                        <div className="about-text">{course.title}</div>
                                    </div>

                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="about-title">
                                            <h5>Описание:</h5>
                                        </div>
                                        <div
                                            className="about-text"
                                            dangerouslySetInnerHTML={{
                                                __html: DOMPurify.sanitize(course.description ?? ""),
                                            }}
                                        />
                                    </div>

                                    <div className="about-infos d-flex mb-4">
                                        <button type="button" className="btn btn-outline-primary btn-sm mr-3">
                                            Китайский
                                        </button>

                                        <button type="button" className="btn btn-outline-primary btn-sm mr-3">
                                            Аудирование
                                        </button>

                                        <button type="button" className="btn btn-outline-primary btn-sm mr-3">
                                            Beginner
                                        </button>
                                    </div>

                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="about-title">
                                            <h5>Длительность курса:</h5>
                                        </div>
                                        <div className="about-text">{formatDurationToText(course.duration)}</div>
                                    </div>

                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="about-title">
                                            <h5>Стоимость курса:</h5>
                                        </div>
                                        <div className="about-text">{course.price}</div>
                                    </div>

                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="text-left">
                                            <a href="#"
                                               className="btn btn-warning btn-sm mr-1 mb-2"
                                            >Студенты</a>
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
                            <h4>Учебный план</h4>
                            <button
                                type="button"
                                className="btn btn-primary mr-1 mb-2"
                                onClick={handleOpenModuleModal}
                            >Новый модуль
                            </button>
                        </div>

                        <div className="widget-body">
                            {modules?.map(module => (
                                <div key={module.id}>
                                    <div
                                        className="d-flex justify-content-between align-items-center mt-2 mb-2">
                                        <div
                                            className="d-flex justify-content-between align-items-center pl-3 pr-3 text-primary header w-100"
                                            style={{backgroundColor: "#dedbe2"}}
                                        >
                                            <h4 className="mb-0">{module.title}</h4>

                                            <div className="td-actions text-right d-flex justify-content-end">
                                                <div className="actions dark d-inline-block">
                                                    <div className="dropdown">
                                                        <button type="button" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                className="dropdown-toggle">
                                                            <i className="la la-plus edit"></i></button>

                                                        <div className="dropdown-menu">
                                                            <Link
                                                                to={`/dashboard/coursesReact/${course.id}/modules/${module.id}/lessons/create`}
                                                                className="dropdown-item"
                                                            >
                                                                <i className="la la-plus"></i>Новый урок
                                                            </Link>

                                                            <a href="#" className="dropdown-item">
                                                                <i className="la la-plus"></i>Новый тест
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" data-toggle="modal" data-target="#modal-stage-1">
                                                    <i className="la la-edit edit"></i>
                                                </button>
                                                <a href="">
                                                    <i className="la la-close delete"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    {module.topics ? (
                                        <div id="stage_1" className="stage-topics" data-id="1">
                                            {module.topics.map((topic) => (
                                                <div
                                                    key={topic.id}
                                                    className="stage-topic d-flex justify-content-between align-items-center mt-3 mb-3"
                                                >
                                                    {topic.lesson && (
                                                        <>
                                                            <div className="col-xl-2">
                                                                <div className="table-img">
                                                                    {topic.lesson.imageFile && (
                                                                        <img
                                                                            src={topic.lesson.imageFile.url}
                                                                            style={{width: 100}}
                                                                            alt={topic.lesson.title}
                                                                        />
                                                                    )}
                                                                </div>
                                                            </div>

                                                            <div className="col-xl-2">
                                                                <div className="badge badge-dark">
                                                                    Урок
                                                                </div>
                                                            </div>
                                                            <div className="col-xl-3">
                                                                {topic.lesson.title}
                                                            </div>

                                                            <div className="col-xl-2">
                                                                {formatDurationToText(topic.lesson.duration)}
                                                            </div>

                                                            <div className="col-2 td-actions d-flex justify-content-end">
                                                                <Link
                                                                    to={`/dashboard/coursesReact/${course.id}/modules/${module.id}/lessons/${topic.lesson.id}/edit`}
                                                                ><i className="la la-edit edit"></i></Link>

                                                                {topic.lesson && (
                                                                    <button
                                                                        onClick={() => handleDeleteLesson(topic.lesson)}
                                                                    ><i className="la la-close delete"></i></button>
                                                                )}
                                                            </div>
                                                        </>
                                                    )}
                                                </div>
                                            ))}
                                        </div>
                                    ) : null}
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>

            <ModuleFormModal
                courseId={course.id}
                isOpen={isModuleModalOpen}
                onClose={handleCloseModuleModal}
                onCreated={handleModuleCreated}
            />
        </PageLayout>
    );
}
