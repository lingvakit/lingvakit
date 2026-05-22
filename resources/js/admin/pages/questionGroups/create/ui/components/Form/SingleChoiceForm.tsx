import {useQuestionGroupForm} from "../../../../../../features/questionGroup/model/useQuestionGroupForm";
import {InputTextField} from "../../../../../../shared/ui/form/InputTextField";
import {InputMediaFiles} from "../../../../../../shared/ui/form/InputMediaFiles";
import {MediaTarget} from "../../../../../../shared/ui/modal/media/types";
import {MediaType} from "../../../../../../entities/media/model/types";
import {TextareaField} from "../../../../../../shared/ui/form/TextareaField";
import {InputRadioField} from "../../../../../../shared/ui/form/InputRadioField";

type Props = {
    form: ReturnType<typeof useQuestionGroupForm>,
    isSavingProgress: boolean,
    openMediaModal: (target: MediaTarget, type: MediaType) => void,
};

export function SingleChoiceForm({
    form,
    isSavingProgress,
    openMediaModal,
}: Props) {
    const handleOpenMediaModal = (
        target: MediaTarget,
        type: MediaType
    ): void => {
        openMediaModal(target, type);
    };

    return (
        <form>
            <div className="row flex-row">
                <div className="col-12">
                    <div className="widget has-shadow">
                        <div
                            className="widget-header bordered no-actions d-flex align-items-center justify-content-between"
                        >
                            <h4>Данные теста</h4>
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
                                mediaFiles={form.fields.mediaFiles}
                                onOpenMediaModal={handleOpenMediaModal}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    );
}