import { Plugin, Widget, toWidget } from "ckeditor5";
import type { ViewDowncastWriter, ViewElement, ViewNode } from "ckeditor5";
import type { MediaType } from "@admin/entities/media/model/types";
import type { MediaTarget } from "@admin/shared/ui/modal/media/types";
import DropdownButtonsUI from "./DropdownButtonsUI";
import InsertMediaCommand from "./InsertMediaCommand";
import { isSafeMediaUrl } from "./safeUrl";

declare module "@ckeditor/ckeditor5-core" {
    interface EditorConfig {
        mediaModal?: {
            open: (target: MediaTarget, type: MediaType) => void;
        };
    }
}

type BlockMediaType = Exclude<MediaType, "image">;
const BLOCK_TYPES: readonly BlockMediaType[] = ["video", "audio", "file"];

function findChildElement(
    parent: ViewElement,
    tagName: string,
): ViewElement | undefined {
    const children: ViewNode[] = Array.from(parent.getChildren());

    for (const child of children) {
        if (child.is("element", tagName)) {
            return child;
        }
    }

    return undefined;
}

function createInner(
    writer: ViewDowncastWriter,
    type: BlockMediaType,
    src: string,
    name: string | undefined,
    forEditing: boolean,
) {
    switch (type) {
        case "video":
            return writer.createContainerElement("video", {
                controls: "controls",
                preload: "metadata",
                src,
            });

        case "audio":
            return writer.createContainerElement("audio", {
                controls: "controls",
                preload: "metadata",
                src,
            });

        case "file": {
            const link = writer.createContainerElement("a", {
                href: src,
                target: "_blank",
                rel: "noopener noreferrer",
                download: "",
            });

            const label = `${forEditing ? "📎 " : ""}${name || "file"}`;
            writer.insert(
                writer.createPositionAt(link, 0),
                writer.createText(label),
            );
            return link;
        }
    }
}

export default class InsertMediaPlugin extends Plugin {
    static get pluginName() {
        return "InsertMedia" as const;
    }

    static get requires() {
        return [Widget, DropdownButtonsUI] as const;
    }

    init(): void {
        const { editor } = this;

        editor.model.schema.register("mediaBlock", {
            inheritAllFrom: "$blockObject",
            allowAttributes: ["type", "src", "name"],
        });

        editor.conversion.for("editingDowncast").elementToElement({
            model: "mediaBlock",
            view: (modelItem, { writer }) => {
                const type = modelItem.getAttribute("type") as BlockMediaType;
                const src = modelItem.getAttribute("src") as string;
                const name = modelItem.getAttribute("name") as
                    | string
                    | undefined;

                const figure = writer.createContainerElement("figure", {
                    class: `media media-${type}`,
                });

                const inner = createInner(writer, type, src, name, true);
                writer.insert(writer.createPositionAt(figure, 0), inner);

                return toWidget(figure, writer, {
                    label: `media ${type}`,
                    hasSelectionHandle: true,
                });
            },
        });

        editor.conversion.for("dataDowncast").elementToElement({
            model: "mediaBlock",
            view: (modelItem, { writer }) => {
                const type = modelItem.getAttribute("type") as BlockMediaType;
                const src = modelItem.getAttribute("src") as string;
                const name = modelItem.getAttribute("name") as
                    | string
                    | undefined;

                const figure = writer.createContainerElement("figure", {
                    class: `media media-${type}`,
                });
                const inner = createInner(writer, type, src, name, false);
                writer.insert(writer.createPositionAt(figure, 0), inner);

                return figure;
            },
        });

        editor.conversion.for("upcast").add((dispatcher) => {
            dispatcher.on(
                "element:figure",
                (_evt, data, conversionApi) => {
                    const viewItem: ViewElement = data.viewItem;

                    if (
                        !conversionApi.consumable.test(viewItem, {
                            name: true,
                            classes: "media",
                        })
                    ) {
                        return;
                    }

                    const type = BLOCK_TYPES.find((t) =>
                        viewItem.hasClass(`media-${t}`),
                    );
                    if (!type) return;

                    const inner = findChildElement(
                        viewItem,
                        type === "file" ? "a" : type,
                    );
                    if (!inner) return;

                    const src = inner.getAttribute(
                        type === "file" ? "href" : "src",
                    );
                    if (!isSafeMediaUrl(src)) return;

                    let name: string | undefined;
                    if (type === "file") {
                        const firstChild = inner.getChild(0);
                        if (firstChild && firstChild.is("$text")) {
                            name = firstChild.data;
                        }
                    }

                    const modelElement = conversionApi.writer.createElement(
                        "mediaBlock",
                        {
                            type,
                            src,
                            ...(name ? { name } : {}),
                        },
                    );

                    if (
                        !conversionApi.safeInsert(
                            modelElement,
                            data.modelCursor,
                        )
                    )
                        return;

                    conversionApi.consumable.consume(viewItem, {
                        name: true,
                        classes: ["media", `media-${type}`],
                    });
                    conversionApi.updateConversionResult(modelElement, data);
                },
                { priority: "high" },
            );

            for (const tag of ["video", "audio"] as const) {
                dispatcher.on(`element:${tag}`, (_evt, data, conversionApi) => {
                    const viewItem: ViewElement = data.viewItem;
                    if (
                        !conversionApi.consumable.test(viewItem, { name: true })
                    )
                        return;

                    const src =
                        viewItem.getAttribute("src") ??
                        findChildElement(viewItem, "source")?.getAttribute(
                            "src",
                        );

                    if (!isSafeMediaUrl(src)) {
                        return;
                    }

                    const modelElement = conversionApi.writer.createElement(
                        "mediaBlock",
                        {
                            type: tag,
                            src,
                        },
                    );

                    if (
                        !conversionApi.safeInsert(
                            modelElement,
                            data.modelCursor,
                        )
                    ) {
                        return;
                    }

                    conversionApi.consumable.consume(viewItem, { name: true });
                    conversionApi.updateConversionResult(modelElement, data);
                });
            }
        });

        editor.commands.add("insertMedia", new InsertMediaCommand(editor));
    }
}
