import {useQuestionGroupForm} from "../../../../../../features/questionGroup/model/useQuestionGroupForm";
import {InputTextField} from "../../../../../../shared/ui/form/InputTextField";
import {InputMediaFiles} from "../../../../../../shared/ui/form/InputMediaFiles";
import {MediaTarget} from "../../../../../../shared/ui/modal/media/types";
import {MediaType} from "../../../../../../entities/media/model/types";
import {TextareaField} from "../../../../../../shared/ui/form/TextareaField";
import {InputRadioField} from "../../../../../../shared/ui/form/InputRadioField";
import {FormEvent} from "react";
import {SingleChoiceQuestionsFields} from "./SingleChoiceQuestionsFields";

type Props = {
    form: ReturnType<typeof useQuestionGroupForm>,
    isSavingProgress: boolean,
    onSubmit: () => Promise<void>,
    openMediaModal: (target: MediaTarget, type: MediaType) => void,
    openAiModal?: () => void,
    questionFields?: boolean
};

export function QuestionGroupForm({
    form,
    isSavingProgress,
    onSubmit,
    openMediaModal,
    openAiModal,
    questionFields = true
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
                                value={form.fields.description ?? ''}
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

                {questionFields && (
                    <SingleChoiceQuestionsFields
                        form={form}
                        openMediaModal={openMediaModal}
                        openAiModal={openAiModal}
                    />
                )}
            </div>
        </form>
    );
}