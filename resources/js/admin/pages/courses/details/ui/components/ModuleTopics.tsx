import {formatDurationToText} from "../../../../../shared/lib/converter";
import {Link} from "react-router-dom";
import {Module} from "../../../../../entities/module/model/types";
import {Lesson} from "../../../../../entities/lesson/model/types";

type Props = {
    courseId: number;
    moduleId: number;
    topics?: Module["topics"];
    onDeleteTopic: (lesson: Lesson | null) => void;
};

export function ModuleTopics({courseId, moduleId, topics, onDeleteTopic}: Props) {
    if (!topics || topics.length === 0) {
        return null;
    }

    return (
        <div className="stage-topics">
            {topics.map(topic => {

                if (topic.lesson) {
                    return (
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
                                            to={`/dashboard/coursesReact/${courseId}/modules/${moduleId}/lessons/${topic.lesson.id}/edit`}
                                        ><i className="la la-edit edit"></i></Link>

                                        {topic.lesson && (
                                            <button
                                                onClick={() => onDeleteTopic(topic.lesson!)}
                                            ><i className="la la-close delete"></i></button>
                                        )}
                                    </div>
                                </>
                            )}
                        </div>
                    );
                }

                if (topic.quiz) {
                    return (
                        <div
                            key={topic.id}
                            className="stage-topic d-flex justify-content-between align-items-center mt-3 mb-3"
                        >
                            {topic.quiz && (
                                <>
                                    <div className="col-xl-2">
                                        <div className="table-img">
                                            {topic.quiz.imageFile && (
                                                <img
                                                    src={topic.quiz.imageFile.url}
                                                    style={{width: 100}}
                                                    alt={topic.quiz.title}
                                                />
                                            )}
                                        </div>
                                    </div>

                                    <div className="col-xl-2">
                                        <div className="badge badge-info">
                                            Тест
                                        </div>
                                    </div>
                                    <div className="col-xl-3">
                                        {topic.quiz.title}
                                    </div>

                                    <div className="col-xl-2">
                                        {formatDurationToText(topic.quiz.timeLimit)}
                                    </div>

                                    <div className="col-2 td-actions d-flex justify-content-end">
                                        <Link
                                            to="#"
                                        ><i className="la la-edit edit"></i></Link>

                                        {topic.quiz && (
                                            <button><i className="la la-close delete"></i></button>
                                        )}
                                    </div>
                                </>
                            )}
                        </div>
                    );
                }
            })}
        </div>
    );
}