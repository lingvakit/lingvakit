import { useId } from "react";
import type { Editor } from "ckeditor5";
import TextareaEditor from "../textarea-editor/TextareaEditor";
import type { MediaTarget } from "../modal/media/types";
import type { MediaType } from "@admin/entities/media/model/types";

type Props = {
    label: string;
    value: string | null | undefined;
    onChange: (value: string) => void;
    onOpenMediaModal: (target: MediaTarget, type: MediaType) => void;
    setEditorRef: (editor: Editor | null) => void;
};

export function TextareaCKEditorField({
    label,
    value,
    onChange,
    onOpenMediaModal,
    setEditorRef,
}: Props) {
    const labelId = useId();

    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label id={labelId} className="col-lg-3 form-control-label">
                {label}
            </label>

            <div className="col-lg-9" role="group" aria-labelledby={labelId}>
                <TextareaEditor
                    value={value ?? ""}
                    onChange={onChange}
                    onOpenMediaModal={onOpenMediaModal}
                    setEditorRef={setEditorRef}
                />
            </div>
        </div>
    );
}
