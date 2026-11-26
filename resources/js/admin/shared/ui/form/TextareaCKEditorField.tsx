import type { Editor } from "ckeditor5";
import TextareaEditor from "../textarea-editor/TextareaEditor";
import type { MediaTarget } from "../modal/media/types";
import type { MediaType } from "@admin/entities/media/model/types";
import { FieldLayout } from "./FieldLayout";
import { useFieldControl } from "./useFieldControl";
import type { FieldErrorValue } from "./validation";

type Props = {
    label: string;
    value: string | null | undefined;
    onChange: (value: string) => void;
    onOpenMediaModal: (target: MediaTarget, type: MediaType) => void;
    setEditorRef: (editor: Editor | null) => void;
    isRequired?: boolean;
    error?: FieldErrorValue;
};

export function TextareaCKEditorField({
    label,
    value,
    onChange,
    onOpenMediaModal,
    setEditorRef,
    isRequired,
    error,
}: Props) {
    const { errorId, hasError } = useFieldControl({ error, isRequired });

    return (
        <FieldLayout
            label={label}
            group="group"
            isRequired={isRequired}
            error={error}
            errorId={errorId}
        >
            <div
                className={hasError ? "border border-danger p-1" : undefined}
                aria-describedby={hasError ? errorId : undefined}
            >
                <TextareaEditor
                    value={value ?? ""}
                    onChange={onChange}
                    onOpenMediaModal={onOpenMediaModal}
                    setEditorRef={setEditorRef}
                />
            </div>
        </FieldLayout>
    );
}
