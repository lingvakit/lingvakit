import PageLayout from "../../../../widgets/layout/PageLayout";
import {useMediaModalManager} from "../../../../shared/ui/modal/media/useMediaModalManager";
import {MediaFile} from "../../../../entities/media/model/types";
import {useCKEditor} from "../../../../shared/ui/modal/media/useCKEditor";
import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";
import {useQuestionGroupForm} from "../../../../features/questionGroup/model/useQuestionGroupForm";
import {SingleChoiceForm} from "./components/Form/SingleChoiceForm";
import {useCreateQuestionGroup} from "../../../../entities/questionGroup/model/hooks";
import {useParams} from "react-router-dom";
import {AiQuestionGeneratorFormModal} from "../../../../shared/ui/modal/ai-generator/AiQuestionGeneratorFormModal";
import {useState} from "react";

export function QuestionsGroupCreatePage() {
    const {quizUuid} = useParams();

    if (!quizUuid) {
        throw new Error('Quiz UUID is required');
    }

    const [isAiModalOpen, setIsAiModalOpen] = useState(false);

    const {
        execute,
        isSavingProcess,
        error
    } = useCreateQuestionGroup();

    const form = useQuestionGroupForm();
    const ckEditor = useCKEditor();

    const mediaModal = useMediaModalManager({
        onCKEditorSelect: ckEditor.handleSelectMediaFile,
        onFormSelect: (file: MediaFile) => {
            form.handlers.setMediaFile(file)
        }
    });

    const handleSubmit = async (): Promise<void> => {
        await execute({
            uuid: crypto.randomUUID(),
            quizUuid: quizUuid,
            title: form.fields.title,
            questionType: "single_choice",
            description: form.fields.description,
            orderIndex: null,
            meta: form.fields.meta,
            questions: form.fields.questions
        });
    };

    if (error) {
        return <>Ошибка: {error}</>
    }

    return (
        <PageLayout title="Новая группа вопросов">
            <SingleChoiceForm
                form={form}
                isSavingProgress={isSavingProcess}
                onSubmit={handleSubmit}
                openMediaModal={mediaModal.open}
                openAiModal={() => setIsAiModalOpen(true)}
            />

            <MediaUploadModal
                isOpen={mediaModal.isOpen}
                mediaType={mediaModal.mediaType}
                onClose={mediaModal.close}
                onSelect={mediaModal.handleSelect}
            />

            <AiQuestionGeneratorFormModal
                theme={form.fields.title}
                isOpen={isAiModalOpen}
                onClose={() => setIsAiModalOpen(false)}
            />
        </PageLayout>
    );
}
