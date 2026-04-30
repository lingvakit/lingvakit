import BaseModal from "../../../../BaseModal";
import {ModuleForm} from "../../../components/ModuleForm";
import {useModuleForm} from "../../../../../../../entities/module/model/useModuleForm";
import {useUpdateModule} from "../../../../../../../entities/module/model/hooks";
import {Module} from "../../../../../../../entities/module/model/types";

type Props = {
    module: Module,
    isOpen: boolean;
    onClose: () => void;
    onUpdated?: (module: Module | null) => void,
};

export function EditModuleModal({
    module,
    isOpen,
    onClose,
    onUpdated
}: Props) {
    const {execute, isSavingProcess, error} = useUpdateModule(module.id);

    const form = useModuleForm({
        title: module.title
    });

    const handleSubmit = async (): Promise<void> => {
        const updatedModule = await execute(form.fields);

        if (updatedModule) {
            onUpdated?.(updatedModule.data);
        }

        onClose();
    };

    return (
        <BaseModal
            isOpen={isOpen}
            title="Редактирование модуля"
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