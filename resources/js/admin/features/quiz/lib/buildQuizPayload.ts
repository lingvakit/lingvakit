import type { QuizFormValues } from "../model/useQuizForm";

export type QuizFormFields = QuizFormValues;

export function buildQuizPayload(fields: QuizFormFields) {
    return {
        categoryId: fields.categoryId,
        title: fields.title,
        description: fields.description,
        audioMediaId: fields.mediaFiles.audio?.id,
        imageMediaId: fields.mediaFiles.image?.id,
        videoMediaId: fields.mediaFiles.video?.id,
        timeLimit: fields.timeLimit,
        passingScore: fields.passingScore,
    };
}
