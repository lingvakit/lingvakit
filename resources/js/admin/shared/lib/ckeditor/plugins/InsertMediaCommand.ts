import {Command} from 'ckeditor5';

export default class InsertMediaCommand extends Command {
    execute({ src, alt }: { src: string, alt?: string }) {
        const editor = this.editor;

        editor.model.change((writer) => {
            const imageElement = writer.createElement('image', {
                src,
                alt: alt || ''
            });

            editor.model.insertContent(
                imageElement,
                editor.model.document.selection
            );
        });
    }

    refresh() {
        this.isEnabled = true;
    }
}