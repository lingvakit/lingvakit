import {Plugin} from "@ckeditor/ckeditor5-core";
import {MediaType} from "../../../../../entities/media/model/types";
import {MediaTarget} from "../../../../ui/modal/media/types";
import DropdownButtonsUI from "./DropdownButtonsUI";
import { toWidget } from '@ckeditor/ckeditor5-widget';
import InsertMediaCommand from "./InsertMediaCommand";

declare module "@ckeditor/ckeditor5-core" {
    interface EditorConfig {
        mediaModal?: {
            open: (target: MediaTarget, type: MediaType) => void;
        };
    }
}

export default class InsertMediaPlugin extends Plugin {
    static get requires() {
        return [DropdownButtonsUI];
    }

    init() {
        const editor = this.editor;

        editor.model.schema.register('mediaBlock', {
            allowWhere: '$block',
            isObject: true,
            isBlock: true,
            allowAttributes: ['type', 'src', 'alt', 'name']
        });

        // Editor downcast (UI)
        editor.conversion.for('editingDowncast').elementToElement({
            model: 'mediaBlock',
            view: (modelItem, {writer}) => {
                const type = modelItem.getAttribute('type');
                const src = modelItem.getAttribute('src');
                const alt = modelItem.getAttribute('alt');
                const name = modelItem.getAttribute('name');

                const figure = writer.createContainerElement('figure', {
                    class: `media media-${type}`
                });

                let inner;

                switch (type) {
                    case 'image':
                        inner = writer.createEmptyElement('img', {src, alt});
                        break;

                    case 'video':
                        inner = writer.createContainerElement('video', {
                            controls: 'controls'
                        });

                        writer.insert(
                            writer.createPositionAt(inner, 0),
                            writer.createEmptyElement('source', {src})
                        );
                        break;

                    case 'audio':
                        inner = writer.createEmptyElement('audio', {
                            controls: 'controls',
                            src
                        });
                        break;

                    case 'file':
                        inner = writer.createContainerElement('a', {
                            href: src,
                            target: '_blank',
                            download: ''
                        });

                        const text = writer.createText(`📎 ${name || 'file'}`);
                        writer.insert(
                            writer.createPositionAt(inner, 0),
                            text
                        );
                        break;
                }

                if (!inner) return;

                writer.insert(
                    writer.createPositionAt(figure, 0),
                    inner
                )

                return toWidget(figure, writer, {
                    label: `media ${type}`,
                    hasSelectionHandle: true
                });
            },
        });

        // Data downcast (HTML)
        editor.conversion.for('dataDowncast').elementToElement({
            model: 'mediaBlock',
            view: (modelItem, {writer}) => {
                const type = modelItem.getAttribute('type');
                const src = modelItem.getAttribute('src');
                const alt = modelItem.getAttribute('alt');
                const name = modelItem.getAttribute('name');

                switch (type) {
                    case 'image':
                        return writer.createEmptyElement('img', {src, alt});

                    case 'video':
                        return writer.createContainerElement('video', {
                            controls: 'controls',
                            src
                        });

                    case 'audio':
                        return writer.createContainerElement('audio', {
                            controls: 'controls',
                            src
                        });

                    case 'file':
                        const link = writer.createContainerElement('a', {
                            href: src,
                            target: '_blank',
                            download: ''
                        });

                        writer.insert(
                            writer.createPositionAt(link, 0),
                            writer.createText(`${name || 'file'}`)
                        );

                        return link;
                }
            },
        });

        editor.conversion.for('upcast').elementToElement({
            model: (viewElement, {writer}) => {
                const name = viewElement.name;

                switch (name) {
                    case 'img':
                        return writer.createElement('mediaBlock', {
                            type: 'image',
                            src: viewElement.getAttribute('src'),
                            alt: viewElement.getAttribute('alt'),
                        });

                    case 'video':
                        return writer.createElement('mediaBlock', {
                            type: 'video',
                            src: viewElement.getAttribute('src'),
                        });

                    case 'audio':
                        return writer.createElement('mediaBlock', {
                            type: 'audio',
                            src: viewElement.getAttribute('src'),
                        });

                    case 'a':
                        const child = viewElement.getChild(0);
                        const name = child && child.is('$text')
                            ? child.data
                            : undefined

                        return writer.createElement('mediaBlock', {
                            type: 'file',
                            src: viewElement.getAttribute('href'),
                            name
                        });

                    default:
                        return null;
                }
            },
            view: {
                name: /^(img|video|audio|a)$/
            }
        });

        editor.commands.add(
            'insertMedia',
            new InsertMediaCommand(editor)
        );
    }
}