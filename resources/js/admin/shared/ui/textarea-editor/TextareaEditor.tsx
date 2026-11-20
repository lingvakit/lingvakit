import { useCallback, useEffect, useMemo, useRef } from "react";
import { CKEditor } from "@ckeditor/ckeditor5-react";
import { ClassicEditor } from "ckeditor5";
import "ckeditor5/ckeditor5.css"; // ✅ без этого редактор рендерится без стилей
import "./textarea-editor.css";

import type { MediaTarget } from "../modal/media/types";
import type { MediaType } from "../../../entities/media/model/types";
import { createEditorConfig } from "../../lib/ckeditor/createEditorConfig";

type Props = {
    value: string;
    onChange: (value: string) => void;
    onOpenMediaModal: (target: MediaTarget, type: MediaType) => void;
    setEditorRef: (editor: ClassicEditor | null) => void;
};

export default function TextareaEditor({
    value,
    onChange,
    onOpenMediaModal,
    setEditorRef,
}: Props) {
    const editorRef = useRef<ClassicEditor | null>(null);

    const latest = useRef({ value, onChange, onOpenMediaModal, setEditorRef });
    latest.current = { value, onChange, onOpenMediaModal, setEditorRef };

    const knownEditorValue = useRef(value);
    const initialData = useRef(value);

    const config = useMemo(
        () =>
            createEditorConfig((target, type) =>
                latest.current.onOpenMediaModal(target, type),
            ),
        [],
    );

    const syncFromProps = useCallback((editor: ClassicEditor) => {
        const external = latest.current.value;
        if (external === knownEditorValue.current) return;
        knownEditorValue.current = external;
        editor.setData(external);
    }, []);

    useEffect(() => {
        if (editorRef.current) syncFromProps(editorRef.current);
    }, [value, syncFromProps]);

    return (
        <CKEditor
            editor={ClassicEditor}
            config={config}
            data={initialData.current}
            onReady={(editor) => {
                editorRef.current = editor;
                latest.current.setEditorRef(editor);

                syncFromProps(editor);
            }}
            onChange={(_, editor) => {
                const data = editor.getData();
                knownEditorValue.current = data;
                latest.current.onChange(data);
            }}
            onAfterDestroy={() => {
                editorRef.current = null;
                latest.current.setEditorRef(null);
            }}
            onError={(error, { phase }) => {
                console.error(`[CKEditor] ошибка на фазе "${phase}"`, error);
            }}
        />
    );
}
