import {Category} from "../../../../../entities/category/model/types";
import {useQuizForm} from "../../../../../features/quiz/model/useQuizForm";
import {SelectCategories} from "./Form/SelectCategories";
import {InputTextField} from "../../../../../shared/ui/form/InputTextField";
import {InputNumberField} from "../../../../../shared/ui/form/InputNumberField";
import {TextareaCKEditorField} from "../../../../../shared/ui/form/TextareaCKEditorField";
import {MediaTarget} from "../../../../../shared/ui/modal/media/types";
import {MediaType} from "../../../../../entities/media/model/types";
import {useCKEditor} from "../../../../../shared/ui/modal/media/useCKEditor";
import {FormEvent} from "react";
import {InputMediaFiles} from "../../../../../shared/ui/form/InputMediaFiles";

type Props = {
    form: ReturnType<typeof useQuizForm>,
    ckEditor: ReturnType<typeof useCKEditor>,
    isSavingProgress: boolean,
    categoriesList: Category[],
    openMediaModal: (target: MediaTarget, type: MediaType) => void,
    onSubmit: () => Promise<void>,
};

export function QuizForm({
    form,
    ckEditor,
    isSavingProgress,
    categoriesList,
    openMediaModal,
    onSubmit,
}: Props) {
    const handleOpenMediaModal = (
        target: MediaTarget,
        type: MediaType
    ): void => {
        openMediaModal(target, type);
    };

    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>
    ): Promise<void> => {
        e.preventDefault();
        await onSubmit();
    }

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
                            <SelectCategories
                                form={form}
                                categoriesList={categoriesList}
                            />

                            <InputTextField
                                label="Заголовок теста"
                                name="title"
                                value={form.fields.title}
                                onChange={form.handlers.changeText}
                                isRequired={true}
                                placeholder="Название теста"
                            />

                            <TextareaCKEditorField
                                label="Описание"
                                value={form.fields.description!}
                                onChange={form.handlers.setDescription}
                                onOpenMediaModal={() => {openMediaModal("editor", "image")}}
                                setEditorRef={ckEditor.setEditorRef}
                            />

                            <InputMediaFiles
                                mediaFiles={form.fields.mediaFiles}
                                onOpenMediaModal={handleOpenMediaModal}
                            />

                            <InputNumberField
                                label="Ограничение времени прохождения теста, мин"
                                name="timeLimit"
                                value={form.fields.timeLimit}
                                onChange={form.handlers.changeNumber}
                                isRequired={true}
                                minDigit={1}
                                maxDigit={600}
                            />

                            <InputNumberField
                                label="Проходной балл, %"
                                name="passingScore"
                                value={form.fields.passingScore}
                                onChange={form.handlers.changeNumber}
                                isRequired={true}
                                minDigit={0}
                                maxDigit={100}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    )
}