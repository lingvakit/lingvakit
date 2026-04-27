import {Command} from "@ckeditor/ckeditor5-core";
import {MediaType} from "../../../../../entities/media/model/types";

export default class InsertMediaCommand extends Command {
    execute(payload: {
        type: MediaType
        src: string,
        alt?: string,
        name?: string,
    }): void {
        const editor = this.editor;

        editor.model.change(writer => {
            const element = writer.createElement('mediaBlock', {
                type: payload.type,
                src: payload.src,
                alt: payload.alt,
                name: payload.name
            });

            editor.model.insertContent(element);
            writer.setSelection(writer.createPositionAfter(element));
        });
    }

    refresh() {
        this.isEnabled = true;
    }
}