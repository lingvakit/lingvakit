import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";
import PageLayout from "../../../../widgets/layout/PageLayout";
import {useLoaderData, useParams} from "react-router-dom";
import {useUpdateQuestionGroup} from "../../../../entities/questionGroup/model/hooks";
import {useQuestionGroupForm} from "../../../../features/questionGroup/model/useQuestionGroupForm";
import {useCKEditor} from "../../../../shared/ui/modal/media/useCKEditor";
import {useMediaModalManager} from "../../../../shared/ui/modal/media/useMediaModalManager";
import {MediaTarget} from "../../../../shared/ui/modal/media/types";
import {MediaFile} from "../../../../entities/media/model/types";
import {QuestionGroup} from "../../../../entities/questionGroup/model/types";
import {QuestionGroupForm} from "../../create/ui/components/Form/QuestionGroupForm";

export function QuestionGroupEditPage() {
    const {quizUuid} = useParams();

    if (!quizUuid) {
        throw new Error('Quiz UUID is required');
    }

    const questionGroup = useLoaderData() as QuestionGroup;
    const {execute, isSavingProcess, error} = useUpdateQuestionGroup();

    const ckEditor = useCKEditor();
    const form = useQuestionGroupForm({
        title: questionGroup.title,
        description: questionGroup.description,
        meta: {
            fontSize: questionGroup.meta?.fontSize ?? 'small'
        },
    });

    const mediaModal = useMediaModalManager({
        onCKEditorSelect: ckEditor.handleSelectMediaFile,
        onFormSelect: (target: MediaTarget, file: MediaFile) => {
            form.handlers.setMediaFile(target, file)
        }
    });

    const handleSubmit = async (): Promise<void> => {
        await execute(form.fields);
    }

    if (error) {
        return <>Ошибка: {error}</>
    }

    return (
        <PageLayout title={questionGroup.title}>
            <QuestionGroupForm
                form={form}
                isSavingProgress={isSavingProcess}
                onSubmit={handleSubmit}
                openMediaModal={mediaModal.open}
                questionFields={false}
            />

            <MediaUploadModal
                isOpen={mediaModal.isOpen}
                mediaType={mediaModal.mediaType}
                onClose={mediaModal.close}
                onSelect={mediaModal.handleSelect}
            />
        </PageLayout>
    );
}
