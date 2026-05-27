import PageLayout from "../../../../widgets/layout/PageLayout";
import {Link, useLoaderData, useParams} from "react-router-dom";
import {Quiz} from "../../../../entities/quiz/model/types";
import {PropertyBlock} from "../../../../shared/ui/blocks/PropertyBlock";
import {formatDurationToText} from "../../../../shared/lib/converter";
import {useState} from "react";
import {noImageLink} from "../../../../shared/constants/links";
import {QuestionGroup} from "../../../../entities/questionGroup/model/types";
import {questionTypeDictionary, questionTypeOptions} from "../../../../entities/question/model/constants";

export function QuizDetailsPage() {
    const quiz = useLoaderData() as Quiz;

    const {courseId, moduleId} = useParams();

    const [isOpenDropdownMenu, setIsOpenDropdownMenu] = useState(false);

    return (
        <PageLayout title={quiz.title}>
            <div className="row flex-row">
                <div className="col-12">
                    <div className="widget has-shadow">
                        <div
                            className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                            <h4>Описание теста</h4>

                            <div className="form-group">
                                <a href="#" type="button"
                                   className="btn btn-primary btn-square mr-1 mb-2">Редактировать</a>
                                <a href="#" type="button"
                                   className="btn btn-danger btn-square mr-1 mb-2">Удалить</a>
                            </div>
                        </div>

                        <div className="widget-body">
                            <div className="row flex-row">
                                <div className="col-xl-3">
                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="about-image">
                                            {quiz.imageFile ? (
                                                <img
                                                    src={quiz.imageFile.url}
                                                    alt={quiz.title}
                                                />
                                            ) : (
                                                <img
                                                    src={noImageLink}
                                                    alt=''
                                                />
                                            )}
                                        </div>
                                    </div>
                                </div>

                                <div className="col-xl-9">
                                    <PropertyBlock
                                        title="Наименование"
                                        description={quiz.title}
                                    />

                                    <PropertyBlock
                                        title="Описание"
                                        description={quiz.description}
                                    />

                                    <PropertyBlock
                                        title="Длительность"
                                        description={formatDurationToText(quiz.timeLimit)}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="col-xl-12">
                    <div className="widget has-shadow">
                        <div
                            className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                            <h4>Вопросы</h4>

                            <div className="text-right">
                                <div className="actions dark">
                                    <div className="dropdown">
                                        <button type="button"
                                                className="btn btn-primary mr-1 mb-2"
                                                onClick={() => setIsOpenDropdownMenu(!isOpenDropdownMenu)}
                                        >+ Добавить
                                        </button>

                                        <div className={`dropdown-menu ${isOpenDropdownMenu ? 'show' : ''}`}>
                                            {questionTypeOptions.map((questionType, i) => (
                                                <Link
                                                    key={i}
                                                    to={`/dashboard/coursesReact/${courseId}/modules/${moduleId}/quizzes/${quiz.uuid}/questionGroups/create?type=${questionType.value}`}
                                                    className="dropdown-item"
                                                ><i className="la la-plus"></i>{questionType.label}</Link>
                                            ))}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="widget-body">
                            {quiz.questionGroups && (
                                <div className="table-responsive">
                                    <table id="sorting-table" className="table mb-0">
                                        <thead>
                                        <tr>
                                            <th>Группа вопросов</th>
                                            <th>Тип вопросов</th>
                                            <th>Действия</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        {quiz.questionGroups.map((questionGroup: QuestionGroup)=> (
                                            <tr key={questionGroup.uuid}>
                                                <td className="text-primary">{questionGroup.title}</td>

                                                <td>{questionTypeDictionary[questionGroup.questionType]}</td>

                                                <td className="td-actions">
                                                    <a href="">
                                                        <i className="la la-eye edit" />
                                                    </a>

                                                    <a href="">
                                                        <i className="la la-edit edit" />
                                                    </a>

                                                    <a href="#">
                                                        <i className="la la-close delete" />
                                                    </a>
                                                </td>
                                            </tr>
                                        ))}
                                        </tbody>
                                    </table>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </PageLayout>
    );
}