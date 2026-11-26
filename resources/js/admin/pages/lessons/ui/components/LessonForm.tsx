import { FormEvent } from "react";
import { useCKEditor } from "@admin/shared/ui/modal/media/useCKEditor";
import { MediaTarget } from "@admin/shared/ui/modal/media/types";
import { MediaType } from "@admin/entities/media/model/types";
import { useLessonForm } from "@admin/features/lesson/model/useLessonForm";
import { InputMediaFiles } from "@admin/shared/ui/form/InputMediaFiles";
import { InputTextField } from "@admin/shared/ui/form/InputTextField";
import { TextareaCKEditorField } from "@admin/shared/ui/form/TextareaCKEditorField";
import { InputNumberField } from "@admin/shared/ui/form/InputNumberField";

type Props = {
    ckEditor: ReturnType<typeof useCKEditor>;
    isSavingProgress: boolean;
    onSubmit: () => Promise<void>;
    openMediaModal: (target: MediaTarget, type: MediaType) => void;
    openAiModal: () => void;
    form: ReturnType<typeof useLessonForm>;
    validationErrors?: Record<string, string[]>;
};

export default function LessonForm({
    ckEditor,
    isSavingProgress,
    onSubmit,
    openMediaModal,
    openAiModal,
    form,
    validationErrors,
}: Props) {
    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>,
    ): Promise<void> => {
        e.preventDefault();
        await onSubmit();
    };

    const handleOpenMediaModal = (target: MediaTarget, type: MediaType) => {
        openMediaModal(target, type);
    };

    return (
        <form className="form-horizontal" onSubmit={handleSubmit}>
            <div className="row flex-row">
                <div className="col-12">
                    <div className="widget has-shadow">
                        <div className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                            <h4>Данные о курсе</h4>
                            <div className="text-right">
                                <button
                                    className="btn btn-primary"
                                    type="submit"
                                    disabled={isSavingProgress}
                                >
                                    {isSavingProgress
                                        ? "Сохранение..."
                                        : "Сохранить"}
                                </button>
                            </div>
                        </div>

                        <div className="widget-body">
                            <InputTextField
                                label="Название урока"
                                name="title"
                                value={form.fields.title}
                                onChange={form.handlers.changeText}
                                isRequired={true}
                                placeholder="Название урока"
                                error={validationErrors?.title}
                            >
                                {form.fields.title.length > 5 && (
                                    <button
                                        type="button"
                                        title="Геренировать текст курса с помощью ИИ"
                                        className="btn btn-gradient-04 btn-square btn-sm mt-2"
                                        onClick={openAiModal}
                                    >
                                        AI помощник
                                    </button>
                                )}
                            </InputTextField>

                            <TextareaCKEditorField
                                label="Описание"
                                value={form.fields.description ?? ""}
                                onChange={form.handlers.setDescription}
                                onOpenMediaModal={openMediaModal}
                                setEditorRef={ckEditor.setEditorRef}
                                error={validationErrors?.description}
                            />

                            <InputMediaFiles
                                target="form"
                                mediaFiles={form.fields.mediaFiles}
                                onOpenMediaModal={handleOpenMediaModal}
                                onRemoveMediaFile={
                                    form.handlers.removeMediaFile
                                }
                            />

                            <InputNumberField
                                label="Длительность, мин"
                                name="duration"
                                value={form.fields.duration}
                                onChange={form.handlers.changeNumber}
                                minDigit={1}
                                maxDigit={600}
                                error={validationErrors?.duration}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    );
}
