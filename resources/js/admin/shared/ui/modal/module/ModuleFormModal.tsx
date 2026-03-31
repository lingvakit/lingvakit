import BaseModal from "../BaseModal";
import {ChangeEvent, FormEvent, useState} from "react";
import {useCreateModule} from "../../../../entities/module/model/hooks";
import {Module} from "../../../../entities/module/model/types";

type Props = {
    courseId: number,
    isOpen: boolean,
    onClose: () => void,
    onCreated?: (module: Module | null) => void,
};

export function ModuleFormModal({courseId, isOpen, onClose, onCreated}: Props) {
    const [title, setTitle] = useState('');

    const {
        create,
        isSaving,
        error
    } = useCreateModule();

    const handleOnChangeTitle = (
        e: ChangeEvent<HTMLInputElement>
    ): void => {
        setTitle(e.target.value);
    };

    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>
    ): Promise<void> => {
        e.preventDefault();

        const module = await create(courseId, {title: title});

        setTitle('');
        onClose();
        onCreated?.(module);
    };

    return (
        <BaseModal
            isOpen={isOpen}
            title="Новый модуль"
            onClose={onClose}
        >
            <form className="form-horizontal" onSubmit={handleSubmit}>
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
                            value={title}
                            onChange={handleOnChangeTitle}
                        />
                    </div>
                </div>

                <div className="form-group">
                    <div className="col-12 mb-3">
                        <button
                            className="btn btn-gradient-01"
                            type="submit"
                            disabled={isSaving}
                        >Сохранить</button>
                    </div>
                </div>
            </form>
        </BaseModal>
    );
}
