import {useQuestionGroupForm} from "../../../../../../features/questionGroup/model/useQuestionGroupForm";
import {InputTextField} from "../../../../../../shared/ui/form/InputTextField";
import {InputMediaFiles} from "../../../../../../shared/ui/form/InputMediaFiles";
import {MediaTarget} from "../../../../../../shared/ui/modal/media/types";
import {MediaType} from "../../../../../../entities/media/model/types";
import {TextareaField} from "../../../../../../shared/ui/form/TextareaField";
import {InputRadioField} from "../../../../../../shared/ui/form/InputRadioField";
import {InputNumberField} from "../../../../../../shared/ui/form/InputNumberField";
import {OptionField} from "./OptionField";
import {FormEvent} from "react";

type Props = {
    form: ReturnType<typeof useQuestionGroupForm>,
    isSavingProgress: boolean,
    onSubmit: () => Promise<void>,
    openMediaModal: (target: MediaTarget, type: MediaType) => void,
    openAiModal: () => void,
};

export function SingleChoiceForm({
    form,
    isSavingProgress,
    onSubmit,
    openMediaModal,
    openAiModal
}: Props) {
    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>
    ): Promise<void> => {
        e.preventDefault();
        await onSubmit();
    };

    const handleOpenMediaModal = (
        target: MediaTarget,
        type: MediaType
    ): void => {
        openMediaModal(target, type);
    };

    return (
        <form
            className="form-horizontal"
            onSubmit={handleSubmit}
        >
            <div className="row flex-row">
                <div className="col-12">
                    <div className="widget has-shadow">
                        <div
                            className="widget-header bordered no-actions d-flex align-items-center justify-content-between"
                        >
                            <h4>Информация о группе</h4>
                            <div className="text-right">
                                <button
                                    className="btn btn-primary"
                                    type="submit"
                                    disabled={isSavingProgress}
                                >
                                    {isSavingProgress ? "Сохранение..." : "Сохранить"}
                                </button>
                            </div>
                        </div>

                        <div className="widget-body">
                            <InputTextField
                                label="Заголовок или общий вопрос"
                                name="title"
                                value={form.fields.title}
                                onChange={form.handlers.changeText}
                                isRequired={true}
                                placeholder="Заголовок для группы вопросов или общая тема вопросов"
                            />

                            <TextareaField
                                label="Описание"
                                name="description"
                                value={form.fields.description}
                                onChange={form.handlers.changeText}
                                isRequired={false}
                                placeholder="Подробное объяснение общего задания"
                            />

                            <InputRadioField
                                title="Размер шрифта вопросов"
                                name="fontSize"
                                currentValue={form.fields.meta?.fontSize ?? 'small'}
                                onChange={(value) =>
                                    form.handlers.setMetaValue("fontSize", value)
                                }
                                items={[
                                    {value: 'small', label: 'Маленький'},
                                    {value: 'medium', label: 'Средний'},
                                    {value: 'large', label: 'Большой'},
                                ]}
                            />

                            <InputMediaFiles
                                target="form"
                                mediaFiles={form.fields.mediaFiles}
                                onOpenMediaModal={handleOpenMediaModal}
                                onRemoveMediaFile={form.handlers.removeMediaFile}
                            />
                        </div>
                    </div>
                </div>

                {/* questions */}
                <div className="col-12">
                    <div className="widget has-shadow">
                        <div
                            className="widget-header bordered no-actions d-flex justify-content-between align-items-center"
                        >
                            <h4>Вопросы</h4>
                            <button
                                className="btn btn-gradient-04"
                                type="button"
                                onClick={openAiModal}
                            >ИИ-генерация вопросов</button>
                        </div>

                        <div className="widget-body">
                            {
                                form.fields.questions.map((question, questionIndex) => (
                                    <div
                                        key={question.uuid}
                                        className="row flex-row my-5"
                                    >
                                        <div className="col-12 mb-3">
                                            <h4>{`Вопрос ${questionIndex + 1}`}</h4>
                                        </div>
                                        <div className="col-md-6 col-12">
                                            <InputTextField
                                                label="Текст вопроса"
                                                name="questionTitle"
                                                value={question.text}
                                                onChange={(e) => form.handlers.updateQuestion(
                                                    question.uuid,
                                                    'text',
                                                    e.target.value
                                                )}
                                                isRequired={true}
                                                placeholder="Введите текст вопроса"
                                                isVertical={true}
                                            />

                                            <InputMediaFiles
                                                target={question.uuid}
                                                mediaFiles={question.mediaFiles}
                                                onOpenMediaModal={handleOpenMediaModal}
                                                onRemoveMediaFile={form.handlers.removeMediaFile}
                                            />

                                            <InputNumberField
                                                label="Баллы"
                                                name="points"
                                                value={question.points}
                                                onChange={(e) =>
                                                    form.handlers.updateQuestion(
                                                        question.uuid,
                                                        'points',
                                                        Number(e.target.value)
                                                    )
                                                }
                                                isRequired={true}
                                                isVertical={true}
                                            />
                                        </div>



                                        <div className="col-md-6 col-12">
                                            <label className="form-control-label">Варианты ответов</label>

                                            {question.options.map(option => (
                                                <OptionField
                                                    key={option.uuid}
                                                    questionUuid={question.uuid}
                                                    optionUuid={option.uuid}

                                                    value={option.text ?? ''}

                                                    checked={question.answer.value[0] === option.uuid}

                                                    onTextChange={(optionUuid, value) => form.handlers.updateOption(
                                                        question.uuid,
                                                        optionUuid,
                                                        'text',
                                                        value
                                                    )}

                                                    onCheckedChange={(optionUuid) => form.handlers.setCorrectOption(
                                                        question.uuid,
                                                        optionUuid,
                                                    )}
                                                />
                                            ))}

                                            <div className="text-left add-option-container">
                                                <button
                                                    type="button"
                                                    className="btn btn-shadow"
                                                    onClick={() => form.handlers.addOption(question.uuid)}
                                                >Добавить вариант</button>
                                            </div>
                                        </div>
                                    </div>
                                ))
                            }

                            <button
                                className="btn btn-primary"
                                type="button"
                                onClick={form.handlers.addQuestion}
                            >Добавить вопрос</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    );
}