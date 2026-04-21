import TextareaEditor from "../textarea-editor/TextareaEditor";
import {MediaTarget} from "../modal/media/types";
import {MediaType} from "../../../entities/media/model/types";
import type {Editor} from "ckeditor5";

type Props = {
    label: string;
    value: string;
    onChange: (value: string) => void;
    onOpenMediaModal: (target: MediaTarget, type: MediaType) => void;
    setEditorRef: (editor: Editor) => void;
};

export function TextareaCKEditorField({label, value, onChange, onOpenMediaModal, setEditorRef}: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label className="col-lg-3 form-control-label">
                {label}
            </label>
            <div className="col-lg-9">
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