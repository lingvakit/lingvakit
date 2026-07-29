import PageLayout from "../../../../widgets/layout/PageLayout";
import {useLoaderData} from "react-router-dom";
import {QuestionGroup} from "../../../../entities/questionGroup/model/types";
import {questionTypeDictionary} from "../../../../entities/question/model/constants";
import {Question} from "../../../../entities/question/model/types";
import QuestionRow from "./components/QuestionRow";
import {useState} from "react";
import {usePatchQuestionAnswer} from "../../../../entities/question/model/hooks";

export default function QuestionGroupDetailsPage() {
    const initialQuestionGroup = useLoaderData() as QuestionGroup;
    const [questionGroup, setQuestionGroup] = useState<QuestionGroup>(initialQuestionGroup);

    const {execute, isSavingProcess} = usePatchQuestionAnswer();

    const handleOptionChange = async (
        questionUuid: string,
        optionUuid: string
    ): Promise<void> => {
        if (isSavingProcess) return;

        try {
            await execute({
                questionUuid: questionUuid,
                payload: {
                    questionType: questionGroup.questionType,
                    value: [optionUuid]
                }
            });

            setQuestionGroup(prev => ({
                ...prev,
                questions: prev.questions.map(q =>
                    q.uuid === questionUuid
                        ? { ...q, answer: { questionType: prev.questionType, value: [optionUuid] } }
                        : q
                )
            }));
        } catch (error) {
            console.error("Ошибка при сохранении ответа", error);
        }
    }

    return (
        <PageLayout title="Группа вопросов">
            <div className="row flex-row">
                <div className="col-xl-12">
                    <div className="widget has-shadow">
                        <div
                            className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                            <h4>Тип вопросов: {questionTypeDictionary[questionGroup.questionType]}</h4>
                            <a href="https://lingvakit.local/dashboard/courses/4/stage-3/quizzes/14/questions/16/edit"
                               type="button" className="btn btn-primary mr-1 mb-2">Редактирование</a>
                        </div>
                        <div className="widget-body">
                            <div className="row flex-row">
                                <div className="col-xl-12">
                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="about-title"><h5>Заголовок:</h5></div>
                                        <div className="about-text">{questionGroup.title}</div>
                                    </div>

                                    <div className="about-infos d-flex flex-column mb-3">
                                        <div className="about-text">
                                            <audio
                                                src="https://lingvakit.local/ms/media/catalog_course_audio_f0/f0203e1b4588.mp3"
                                                preload="auto"></audio>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="col-xl-12">
                    <div className="accordion">
                        <div className="widget has-shadow">
                            <div
                                className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                                <h4>Вопросы</h4>

                                <a href="#"
                                   type="button"
                                   className="btn btn-primary mr-1 mb-2"
                                >Добавить вопрос</a>
                            </div>

                            <div className="widget-body">
                                <div className="table-responsive">
                                    <table className="table mb-0">
                                        <thead>
                                        <tr>
                                            <th>Ответ</th>
                                            <th>Правильный ответ</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        {questionGroup.questions.map((question: Question) => (
                                            <QuestionRow
                                                key={question.uuid}
                                                question={question}
                                                isUpdating={isSavingProcess}
                                                onChangeCorrectOption={handleOptionChange}
                                            />
                                        ))}

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </PageLayout>
    );
}