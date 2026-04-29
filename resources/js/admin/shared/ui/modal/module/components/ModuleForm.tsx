import {useModuleForm} from "../../../../../entities/module/model/useModuleForm";

type Props = {
    form: ReturnType<typeof useModuleForm>;
    isSavingProcess: boolean;
    error: string|null;
    onSubmit: () => Promise<void>;
};

export function ModuleForm({
    form,
    isSavingProcess,
    error,
    onSubmit,
}: Props) {
    const handleSubmit = async () => {
        await onSubmit();
    };

    return (
        <form
            className="form-horizontal"
            onSubmit={handleSubmit}
        >
            {error && (
                <div className="alert alert-danger" role="alert">
                    {error}
                </div>
            )}

            <div className="form-group">
                <div className="col-12 mb-3">
                    <label className="form-control-label">
                        Название модуля
                        <span className="text-danger ml-2">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        className="form-control"
                        placeholder="Модуль 1"
                        value={form.fields.title}
                        onChange={form.handlers.changeTitle}
                    />
                </div>
            </div>

            <div className="form-group">
                <div className="col-12 mb-3">
                    <button
                        className="btn btn-gradient-01"
                        type="submit"
                        disabled={isSavingProcess}
                    >Сохранить</button>
                </div>
            </div>
        </form>
    );
}