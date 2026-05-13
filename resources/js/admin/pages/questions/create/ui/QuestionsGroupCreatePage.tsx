import PageLayout from "../../../../widgets/layout/PageLayout";
import {SingleChoiceForm} from "./components/Form/SingleChoiceForm";
import {useQuestionGroupForm} from "../../../../features/questionGroup/model/useQuestionGroupForm";
import {useMediaModalManager} from "../../../../shared/ui/modal/media/useMediaModalManager";
import {MediaFile} from "../../../../entities/media/model/types";
import {useCKEditor} from "../../../../shared/ui/modal/media/useCKEditor";
import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";

export function QuestionsGroupCreatePage() {
    const form = useQuestionGroupForm();
    const ckEditor = useCKEditor();

    const mediaModal = useMediaModalManager({
        onCKEditorSelect: ckEditor.handleSelectMediaFile,
        onFormSelect: (file: MediaFile) => {
            form.handlers.setMediaFile(file)
        }
    });

    return (
        <PageLayout title="Новая группа вопросов">
            <SingleChoiceForm
                form={form}
                isSavingProgress={false}
                openMediaModal={mediaModal.open}
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
