import { Plugin } from "ckeditor5";
import InsertMediaCommand from "./InsertMediaCommand";

export default class InsertMediaPlugin extends Plugin {
    init() {
        const editor = this.editor;

        editor.commands.add(
            "insertMedia",
            new InsertMediaCommand(editor)
        );
    }
}