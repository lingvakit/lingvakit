import {Plugin} from "@ckeditor/ckeditor5-core";
import {ButtonView, createDropdown} from "@ckeditor/ckeditor5-ui";
import {MediaType} from "../../../../../entities/media/model/types";

export default class DropdownButtonsUI extends Plugin {
    init() {
        const editor = this.editor;

        editor.ui.componentFactory.add('insertMediaDropdown', locale => {
            const dropdown = createDropdown(locale);

            dropdown.buttonView.set({
                label: 'Вставить файл',
                withText: true,
                tooltip: true,
            });

            const createButton = (
                label: string,
                type: MediaType
            ): ButtonView => {
                const button = new ButtonView(locale);

                button.set({label, withText: true});
                button.on('execute', () => {
                    editor.config.get('mediaModal')?.open('editor', type);
                });

                return button;
            };

            dropdown.panelView.children.add(
                createButton('Изображение', 'image')
            );

            dropdown.panelView.children.add(
                createButton('Видео', 'video')
            );

            dropdown.panelView.children.add(
                createButton('Аудио', 'audio')
            );

            dropdown.panelView.children.add(
                createButton('Файл', 'file')
            );

            return dropdown;
        });
    }
}