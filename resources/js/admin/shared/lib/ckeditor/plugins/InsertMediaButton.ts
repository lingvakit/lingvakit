import {Plugin, ButtonView} from "ckeditor5";
import {MediaType} from "../../../../entities/media/model/types.ts";
import InsertMediaCommand from "./InsertMediaCommand.ts";
import {MediaTarget} from "../../../ui/modal/media/types.ts";

declare module "ckeditor5" {
    interface EditorConfig {
        mediaModal?: {
            open: (target: MediaTarget, type: MediaType) => void;
        };
    }
}

export default class InsertMediaButton extends Plugin {
    init(): void {
        const editor = this.editor;

        editor.commands.add('insertMedia', new InsertMediaCommand(editor));

        editor.ui.componentFactory.add("insertMediaButton", locale => {
            const button = new ButtonView(locale);

            button.set({
                label: "Insert Media Button",
                withText: true,
                tooltip: true,
            })

            button.on('execute', () => {
                const modal = editor.config.get('mediaModal');
                modal?.open('editor', 'image');
            });

            return button;
        });
    }
};
