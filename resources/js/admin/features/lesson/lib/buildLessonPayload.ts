import { LessonFormValues } from "../model/useLessonForm";

export function buildLessonPayload(fields: LessonFormValues) {
    return {
        title: fields.title,
        description: fields.description,
        duration: fields.duration,
        audioMediaId: fields.mediaFiles?.audio?.id,
        imageMediaId: fields.mediaFiles?.image?.id,
        videoMediaId: fields.mediaFiles?.video?.id,
    };
}
