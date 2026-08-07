import BaseModal from "../../BaseModal";
import {Question} from "../../../../../entities/question/model/types";
import {useCreateQuestion} from "../../../../../entities/question/model/hooks";
import {useQuestionForm} from "../../../../../features/question/model/useQuestionForm";
import {QuestionModalForm} from "./components/QuestionModalForm";

type Props = {
    questionGroupUuid: string;
    isOpen: boolean,
    onClose: () => void,
    onCreated?: (question: Question | null) => void,
};

export function CreateQuestionModal({
    questionGroupUuid,
    isOpen,
    onClose,
    onCreated,
}: Props) {
    const {execute, isSavingProcess, error} = useCreateQuestion();

    const form = useQuestionForm();

    const handleSubmit = async (): Promise<void> => {
        const createdQuestion = await execute({
            questionGroupUuid: questionGroupUuid,
            uuid: crypto.randomUUID(),
            text: form.fields.text,
            explanation: form.fields.explanation,
            points: form.fields.points,
            orderIndex: null,
            type: form.fields.type,
            settings: null,
            answer: form.fields.answer,
            options: form.fields.options
        });

        if (createdQuestion) {
            onCreated?.(createdQuestion);
        }

        onClose();
    };

    return (
        <BaseModal
            isOpen={isOpen}
            title="Новый вопрос"
            onClose={onClose}
        >
            <QuestionModalForm
                form={form}
                isSavingProcess={isSavingProcess}
                error={error}
                onSubmit={handleSubmit}
            />
        </BaseModal>
    );
}
