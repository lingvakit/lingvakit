import {Module} from "../../../../../entities/module/model/types";
import {Lesson} from "../../../../../entities/lesson/model/types";
import {Link} from "react-router-dom";
import {ModuleTopics} from "./ModuleTopics";

type Props = {
    courseId: number;
    modules: Module[];
    onDeleteTopic: (lesson: Lesson | null) => Promise<void>;
};

export function CourseModules({courseId, modules, onDeleteTopic}: Props) {
    return (
        <>
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
                                                to={`/dashboard/coursesReact/${courseId}/modules/${module.id}/lessons/create`}
                                                className="dropdown-item"
                                            >
                                                <i className="la la-plus"></i>Новый урок
                                            </Link>

                                            <Link
                                                to={`/dashboard/coursesReact/${courseId}/modules/${module.id}/quizzes/create`}
                                                className="dropdown-item"
                                            >
                                                <i className="la la-plus"></i>Новый тест
                                            </Link>
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

                    <ModuleTopics
                        topics={module.topics}
                        courseId={courseId}
                        moduleId={module.id}
                        onDeleteTopic={() => onDeleteTopic}
                    />
                </div>
            ))}
        </>
    );
}
