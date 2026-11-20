import {
    Collection,
    Plugin,
    ViewModel,
    addListToDropdown,
    createDropdown,
} from "ckeditor5";
import type { ListDropdownItemDefinition } from "ckeditor5";
import type { MediaType } from "../../../../../entities/media/model/types";

const ITEMS: ReadonlyArray<{ label: string; type: MediaType }> = [
    { label: "Изображение", type: "image" },
    { label: "Видео", type: "video" },
    { label: "Аудио", type: "audio" },
    { label: "Файл", type: "file" },
];

export default class DropdownButtonsUI extends Plugin {
    static get pluginName() {
        return "InsertMediaDropdownUI" as const;
    }

    init(): void {
        const { editor } = this;

        editor.ui.componentFactory.add("insertMediaDropdown", (locale) => {
            const dropdown = createDropdown(locale);

            const items = new Collection<ListDropdownItemDefinition>();
            for (const { label, type } of ITEMS) {
                items.add({
                    type: "button",
                    model: new ViewModel({
                        label,
                        withText: true,
                        commandParam: type,
                    }),
                });
            }
            addListToDropdown(dropdown, items);

            dropdown.buttonView.set({
                label: "Вставить файл",
                withText: true,
                tooltip: true,
            });

            const command = editor.commands.get("insertMedia");
            if (command) {
                dropdown.bind("isEnabled").to(command, "isEnabled");
            }

            dropdown.on("execute", (evt) => {
                const { commandParam } = evt.source as {
                    commandParam: MediaType;
                };
                editor.config.get("mediaModal")?.open("editor", commandParam);
            });

            return dropdown;
        });
    }
}
