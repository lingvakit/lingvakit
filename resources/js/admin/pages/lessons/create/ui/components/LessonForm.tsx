import TextareaEditor from "../../../../../shared/ui/textarea-editor/TextareaEditor";
import {FormEvent} from "react";
import {useCKEditor} from "../../../../../shared/ui/modal/media/useCKEditor";
import {MediaTarget} from "../../../../../shared/ui/modal/media/types";
import {MediaType} from "../../../../../entities/media/model/types";
import {useLessonForm} from "../../../../../features/lesson/create/model/useLessonForm";
import {InputMediaFiles} from "../../../../../shared/ui/form/InputMediaFiles";

type Props = {
    ckEditor: ReturnType<typeof useCKEditor>
    isSavingProgress: boolean;
    onSubmit: () => Promise<void>;
    openMediaModal: (target: MediaTarget, type: MediaType) => void;
    openAiModal: () => void;
    form: ReturnType<typeof useLessonForm>
};

export default function LessonForm({ckEditor, isSavingProgress, onSubmit, openMediaModal, openAiModal, form }: Props) {
    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>
    ): Promise<void> => {
        e.preventDefault();
        await onSubmit();
    }

    const handleOpenMediaModal = (
        target: MediaTarget,
        type: MediaType
    ) => {
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
                            className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                            <h4>Данные о курсе</h4>

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
                            <div className="form-group row d-flex align-items-center mb-5">
                                <label className="col-lg-3 form-control-label">
                                    Название урока
                                    <span className="text-danger ml-2">*</span>
                                </label>
                                <div className="col-lg-9">
                                    <input
                                        type="text"
                                        name="title"
                                        className="form-control"
                                        placeholder="Наименование"
                                        value={form.fields.title}
                                        onChange={form.handlers.handleChange}
                                    />

                                    {form.fields.title.length > 5 && (
                                        <button
                                            type="button"
                                            title="Геренировать текст курса с помощью ИИ"
                                            className="btn btn-gradient-04 btn-square btn-sm mt-1"
                                            onClick={openAiModal}
                                        >AI помощник</button>
                                    )}
                                </div>
                            </div>

                            <div className="form-group row d-flex align-items-center mb-5">
                                <label className="col-lg-3 form-control-label">Описание</label>
                                <div className="col-lg-9">
                                    <TextareaEditor
                                        value={form.fields.description ?? ""}
                                        onChange={form.handlers.setDescription}
                                        onOpenMediaModal={openMediaModal}
                                        setEditorRef={ckEditor.setEditorRef}
                                    />
                                </div>
                            </div>

                            <InputMediaFiles
                                target={"form"}
                                mediaFiles={form.fields.mediaFiles}
                                onOpenMediaModal={handleOpenMediaModal}
                                onRemoveMediaFile={form.handlers.removeMediaFile}
                            />

                            <div className="form-group row align-items-center mb-5">
                                <label className="col-lg-3 form-control-label">
                                    Длительность, мин
                                </label>
                                <div className="col-lg-9">
                                    <input
                                        type="number"
                                        name="duration"
                                        className="form-control"
                                        placeholder="100"
                                        min={0}
                                        value={form.fields.duration}
                                        onChange={form.handlers.handleChange}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    );
}
