import { fireEvent, render, screen } from "@testing-library/react";
import type { MediaType } from "@admin/entities/media/model/types";
import type { MediaFields } from "../../../types/form";
import { InputMediaFiles } from "../InputMediaFiles";
import { InputRadioField } from "../InputRadioField";
import { TextareaCKEditorField } from "../TextareaCKEditorField";
import { MODAL_IMAGE_THUMB_SIZE } from "@admin/entities/media/model/constants";

// Настоящий редактор CKEditor в jsdom не поднимается: подменяем лёгкой заглушкой.
vi.mock("../../textarea-editor/TextareaEditor", () => ({
    default: ({
        value,
        onChange,
    }: {
        value: string;
        onChange: (v: string) => void;
    }) => (
        <div
            data-testid="editor"
            data-value={value}
            onClick={() => onChange("changed")}
        />
    ),
}));

const noop = () => {};

describe("TextareaCKEditorField", () => {
    const base = {
        label: "Описание",
        value: "<p>x</p>",
        onChange: noop,
        onOpenMediaModal: noop,
        setEditorRef: noop,
    };

    it("без ошибки нет рамки и текста", () => {
        const { container } = render(<TextareaCKEditorField {...base} />);
        expect(container.querySelector(".border-danger")).toBeNull();
        expect(container.querySelector(".invalid-feedback")).toBeNull();
    });

    it("с ошибкой оборачивает редактор в красную рамку и показывает текст", () => {
        const { container } = render(
            <TextareaCKEditorField {...base} error={["Слишком длинно"]} />,
        );
        const wrapper = container.querySelector(".border.border-danger");
        expect(wrapper).not.toBeNull();
        expect(wrapper).toContainElement(screen.getByTestId("editor"));
        expect(screen.getByText("Слишком длинно").id).toBe(
            wrapper!.getAttribute("aria-describedby"),
        );
    });

    it("рамка-обёртка есть всегда: редактор не пересоздаётся при появлении ошибки", () => {
        const { rerender } = render(<TextareaCKEditorField {...base} />);
        const editor = screen.getByTestId("editor");

        rerender(<TextareaCKEditorField {...base} error="Ошибка" />);

        expect(screen.getByTestId("editor")).toBe(editor); // тот же DOM-узел, а не новый
    });

    it("правая колонка — группа, подписанная заголовком", () => {
        render(<TextareaCKEditorField {...base} />);
        expect(
            screen.getByRole("group", { name: "Описание" }),
        ).toBeInTheDocument();
    });

    it.each([[null], [undefined]])(
        "%s вместо значения превращается в пустую строку",
        (value) => {
            render(<TextareaCKEditorField {...base} value={value} />);
            expect(screen.getByTestId("editor")).toHaveAttribute(
                "data-value",
                "",
            );
        },
    );

    it("пробрасывает onChange редактора и показывает звёздочку", () => {
        const onChange = vi.fn();
        render(
            <TextareaCKEditorField {...base} onChange={onChange} isRequired />,
        );
        fireEvent.click(screen.getByTestId("editor"));
        expect(onChange).toHaveBeenCalledWith("changed");
        expect(screen.getByText("*")).toBeInTheDocument();
    });
});

describe("InputRadioField", () => {
    const items = [
        { value: "a", label: "Первый" },
        { value: "b", label: "Второй" },
    ];
    const make = (p: object = {}) => (
        <InputRadioField
            title="Тип"
            name="kind"
            currentValue="a"
            onChange={noop}
            items={items}
            {...p}
        />
    );

    it("отмечает текущее значение и вызывает onChange с value", () => {
        const onChange = vi.fn();
        render(make({ onChange }));
        expect(screen.getByLabelText("Первый")).toBeChecked();
        expect(screen.getByLabelText("Второй")).not.toBeChecked();
        fireEvent.click(screen.getByLabelText("Второй"));
        expect(onChange).toHaveBeenCalledWith("b");
    });

    it("группа подписана заголовком (radiogroup)", () => {
        render(make());
        expect(
            screen.getByRole("radiogroup", { name: "Тип" }),
        ).toBeInTheDocument();
    });

    it("с ошибкой помечает группу невалидной и показывает текст", () => {
        render(make({ error: "Выберите тип" }));
        expect(screen.getByRole("radiogroup")).toHaveAttribute(
            "aria-invalid",
            "true",
        );
        expect(screen.getByText("Выберите тип")).toBeInTheDocument();
    });

    it("без ошибки aria-invalid нет", () => {
        render(make());
        expect(screen.getByRole("radiogroup")).not.toHaveAttribute(
            "aria-invalid",
        );
    });
});

describe("InputMediaFiles", () => {
    const empty: MediaFields = { audio: null, image: null, video: null };
    type MediaFile = NonNullable<MediaFields["image"]>;
    const file = (id: number, type: MediaType): MediaFile => ({
        id,
        url: `/m/${id}`,
        fileName: `f${id}`,
        type,
    });
    const make = (mediaFiles: MediaFields, p: object = {}) => (
        <InputMediaFiles
            target="form"
            mediaFiles={mediaFiles}
            onOpenMediaModal={noop}
            onRemoveMediaFile={noop}
            {...p}
        />
    );

    it("без файлов показывает только кнопку выбора", () => {
        const { container } = render(make(empty));
        expect(container.querySelector(".preview")).toBeNull();
        expect(
            screen.getByRole("button", { name: "Выбрать медиа файл" }),
        ).toBeInTheDocument();
    });

    it("рисует превью в порядке audio → image → video с hidden-полями", () => {
        const { container } = render(
            make({
                audio: file(1, "audio"),
                image: file(2, "image"),
                video: file(3, "video"),
            }),
        );
        const hidden = [
            ...container.querySelectorAll<HTMLInputElement>(
                "input[type=hidden]",
            ),
        ];
        expect(hidden.map((i) => [i.name, i.value])).toEqual([
            ["audio_form", "1"],
            ["image_form", "2"],
            ["video_form", "3"],
        ]);
        expect(container.querySelector("audio")).toHaveAttribute("src", "/m/1");
        expect(container.querySelector("img")).toHaveAttribute(
            "src",
            `/m/2?w=${MODAL_IMAGE_THUMB_SIZE}`,
        );
        expect(container.querySelector("img")).toHaveAttribute("alt", "f2");
        expect(container.querySelector("video")).toHaveAttribute("src", "/m/3");
    });

    it("«Удалить» отменяет переход по ссылке и сообщает target и тип", () => {
        const onRemove = vi.fn();
        render(
            make(
                { ...empty, image: file(2, "image") },
                { onRemoveMediaFile: onRemove },
            ),
        );
        expect(fireEvent.click(screen.getByText("Удалить"))).toBe(false);
        expect(onRemove).toHaveBeenCalledWith("form", "image");
    });

    it("кнопка выбора открывает модалку с target и типом image", () => {
        const onOpen = vi.fn();
        render(make(empty, { onOpenMediaModal: onOpen }));
        fireEvent.click(
            screen.getByRole("button", { name: "Выбрать медиа файл" }),
        );
        expect(onOpen).toHaveBeenCalledWith("form", "image");
    });

    it("показывает ошибку и связывает её с кнопкой выбора", () => {
        render(make(empty, { error: ["Файл слишком большой"] }));
        expect(
            screen.getByRole("button", { name: "Выбрать медиа файл" }),
        ).toHaveAttribute(
            "aria-describedby",
            screen.getByText("Файл слишком большой").id,
        );
    });

    it("без ошибки aria-describedby у кнопки нет", () => {
        render(make(empty));
        expect(
            screen.getByRole("button", { name: "Выбрать медиа файл" }),
        ).not.toHaveAttribute("aria-describedby");
    });
});
