import {useLoaderData} from "react-router-dom";
import {Course} from "../../../../entities/course/model/types";
import PageLayout from "../../../../widgets/layout/PageLayout";
import {formatDate, formatDurationToText} from "../../../../shared/lib/converter";
import {useState} from "react";
import {ModuleFormModal} from "../../../../shared/ui/modal/module/ModuleFormModal";
import {Module} from "../../../../entities/module/model/types";
import {Lesson} from "../../../../entities/lesson/model/types";
import {useDeleteLesson} from "../../../../entities/lesson/model/hooks";
import {CourseModules} from "./components/CourseModules";
import {CourseTag} from "./components/CourseTag";
import {CourseProperty} from "./components/CourseProperty";

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
                                            <img
                                                src={course.imageUrl}
                                                alt={course.title}
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div className="col-xl-9">
                                    <CourseProperty
                                        title="Автор курса"
                                        description={course.author}
                                    />

                                    <CourseProperty
                                        title="Дата публикации"
                                        description={formatDate(course.createdAt)}
                                    />

                                    <CourseProperty
                                        title="Наименование"
                                        description={course.title}
                                    />

                                    <CourseProperty
                                        title="Описание"
                                        description={course.description}
                                    />

                                    <div className="about-infos d-flex mb-4">
                                        <CourseTag title="Китайский" />
                                        <CourseTag title="Аудирование" />
                                        <CourseTag title="Начальный уровень" />
                                    </div>

                                    <CourseProperty
                                        title="Длительность курса"
                                        description={formatDurationToText(course.duration)}
                                    />

                                    <CourseProperty
                                        title="Стоимость курса"
                                        description={course.price ? String(course.price) : "Бесплатно"}
                                    />

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
                            >Новый модуль</button>
                        </div>

                        <div className="widget-body">
                            <CourseModules
                                courseId={course.id}
                                modules={modules}
                                onDeleteTopic={handleDeleteLesson}
                            />
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
