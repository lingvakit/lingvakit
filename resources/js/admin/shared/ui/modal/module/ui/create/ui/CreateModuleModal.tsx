import {useCreateModule} from "../../../../../../../entities/module/model/hooks";
import BaseModal from "../../../../BaseModal";
import {ModuleForm} from "../../../components/ModuleForm";
import {useModuleForm} from "../../../../../../../entities/module/model/useModuleForm";
import {Module} from "../../../../../../../entities/module/model/types";

type Props = {
    courseId: number;
    isOpen: boolean,
    onClose: () => void,
    onCreated?: (module: Module | null) => void,
};

export function CreateModuleModal({
    courseId,
    isOpen,
    onClose,
}: Props) {
    const {execute, isSavingProcess, error} = useCreateModule();

    const form = useModuleForm();

    const handleSubmit = async (): Promise<void> => {
        await execute({
            courseId: courseId,
            title: form.fields.title,
        });

        onClose();
    };

    return (
        <BaseModal
            isOpen={isOpen}
            title="Новый модуль"
            onClose={onClose}
        >
            <ModuleForm
                form={form}
                isSavingProcess={isSavingProcess}
                error={error}
                onSubmit={handleSubmit}
            />
        </BaseModal>
    );
}