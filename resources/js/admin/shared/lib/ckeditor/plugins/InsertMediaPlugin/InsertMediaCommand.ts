import { Command } from "@ckeditor/ckeditor5-core";
import { MediaType } from "@admin/entities/media/model/types";
import { isSafeMediaUrl } from "./safeUrl";

export type InsertMediaPayload = {
    type: MediaType;
    src: string;
    alt?: string;
    name?: string;
};

export default class InsertMediaCommand extends Command {
    override refresh(): void {
        const { model } = this.editor;
        const position = model.document.selection.getFirstPosition();

        this.isEnabled =
            position !== null &&
            model.schema.findAllowedParent(position, "mediaBlock") !== null;
    }

    override execute(payload: InsertMediaPayload): void {
        const { editor } = this;

        if (!isSafeMediaUrl(payload.src)) {
            console.warn(
                "[InsertMedia] Небезопасный или пустой URL, вставка отменена",
            );

            return;
        }

        if (payload.type === "image") {
            editor.execute("insertImage", {
                source: [{ src: payload.src, alt: payload.alt ?? "" }],
            });

            return;
        }

        editor.model.change((writer) => {
            const attributes: Record<string, string> = {
                type: payload.type,
                src: payload.src,
            };

            if (payload.name) attributes.name = payload.name;

            const element = writer.createElement("mediaBlock", attributes);

            editor.model.insertObject(element, null, null, {
                setSelection: "after",
            });
        });
    }
}
