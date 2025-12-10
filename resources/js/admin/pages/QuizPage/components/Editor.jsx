import React from "react";
import { CKEditor } from "@ckeditor/ckeditor5-react";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default function Editor({ value, onChange }) {
    return (
        <CKEditor
            editor={ClassicEditor}
            data={value || ""}
            onChange={(_, editor) => onChange(editor.getData())}
        />
    );
}