import { fireEvent, render, screen } from "@testing-library/react";
import { InputNumberField } from "../InputNumberField";
import { InputTextField } from "../InputTextField";
import { SelectField } from "../SelectField";
import { TextareaField } from "../TextareaField";

const noop = () => {};
const options = [
    { value: 1, label: "Один" },
    { value: "2", label: "Два", disabled: true },
];

describe.each([
    ["InputTextField", (p: object) => <InputTextField label="Название" name="title" value="" onChange={noop} {...p} />],
    ["InputNumberField", (p: object) => <InputNumberField label="Название" name="title" value={1} onChange={noop} {...p} />],
    ["TextareaField", (p: object) => <TextareaField label="Название" name="title" value="" onChange={noop} {...p} />],
    ["SelectField", (p: object) => <SelectField label="Название" name="title" value={1} options={options} onChange={noop} {...p} />],
])("%s (общее поведение)", (_name, make) => {
    it("связывает label и контрол", () => {
        render(make({}));
        expect(screen.getByLabelText(/Название/)).toHaveAttribute("name", "title");
    });

    it("без ошибки не помечает поле невалидным", () => {
        render(make({}));
        const control = screen.getByLabelText(/Название/);
        expect(control).not.toHaveClass("is-invalid");
        expect(control).not.toHaveAttribute("aria-invalid");
        expect(control).not.toHaveAttribute("aria-describedby");
        expect(document.querySelector(".invalid-feedback")).toBeNull();
    });

    it("с ошибкой красит поле и показывает текст под ним", () => {
        render(make({ error: "Поле обязательно" }));
        const control = screen.getByLabelText(/Название/);
        const message = screen.getByText("Поле обязательно");
        expect(control).toHaveClass("is-invalid");
        expect(control).toHaveAttribute("aria-invalid", "true");
        expect(control.getAttribute("aria-describedby")).toBe(message.id);
        expect(control.compareDocumentPosition(message) & Node.DOCUMENT_POSITION_FOLLOWING).toBeTruthy();
    });

    it("показывает только первую ошибку из массива Laravel", () => {
        render(make({ error: ["Первая", "Вторая"] }));
        expect(screen.getByText("Первая")).toBeInTheDocument();
        expect(screen.queryByText("Вторая")).not.toBeInTheDocument();
    });

    it.each([[undefined], [null], [""], [[]]])("%j считается отсутствием ошибки", (error) => {
        render(make({ error }));
        expect(screen.getByLabelText(/Название/)).not.toHaveClass("is-invalid");
    });

    it("рисует звёздочку и aria-required", () => {
        render(make({ isRequired: true }));
        expect(screen.getByText("*")).toBeInTheDocument();
        expect(screen.getByLabelText(/Название/)).toHaveAttribute("aria-required", "true");
    });

    it("children выводятся после текста ошибки", () => {
        render(make({ error: "Ошибка", children: <button type="button">AI помощник</button> }));
        const message = screen.getByText("Ошибка");
        const button = screen.getByRole("button", { name: "AI помощник" });
        expect(message.compareDocumentPosition(button) & Node.DOCUMENT_POSITION_FOLLOWING).toBeTruthy();
    });

    it("у разных экземпляров разные id", () => {
        render(<>{make({})}{make({})}</>);
        const [a, b] = screen.getAllByLabelText(/Название/);
        expect(a.id).not.toBe(b.id);
    });
});

describe.each([
    ["InputTextField", (p: object) => <InputTextField label="Название" name="t" value="" onChange={noop} {...p} />],
    ["InputNumberField", (p: object) => <InputNumberField label="Название" name="t" value={1} onChange={noop} {...p} />],
    ["TextareaField", (p: object) => <TextareaField label="Название" name="t" value="" onChange={noop} {...p} />],
])("%s (раскладки)", (_name, make) => {
    it("по умолчанию горизонтальная", () => {
        const { container } = render(make({}));
        expect(container.querySelector("label.col-lg-3.form-control-label")).not.toBeNull();
        expect(container.querySelector(".col-12")).toBeNull();
    });

    it("isVertical: всё внутри col-12, ошибка тоже", () => {
        const { container } = render(make({ isVertical: true, error: "Ошибка" }));
        expect(container.querySelector(".col-12 > label.form-control-label")).not.toBeNull();
        expect(container.querySelector(".col-12 .invalid-feedback")).not.toBeNull();
        expect(container.querySelector(".col-lg-3")).toBeNull();
    });

    it("не ставит нативный required", () => {
        render(make({ isRequired: true }));
        expect(screen.getByLabelText(/Название/)).not.toHaveAttribute("required");
    });
});

describe("InputTextField", () => {
    it("вызывает onChange при вводе", () => {
        const onChange = vi.fn();
        render(<InputTextField label="Название" name="title" value="" onChange={onChange} />);
        fireEvent.change(screen.getByLabelText(/Название/), { target: { value: "Урок" } });
        expect(onChange).toHaveBeenCalledTimes(1);
    });
});

describe("InputNumberField", () => {
    it("type=number, min/max и числовое значение", () => {
        render(<InputNumberField label="Время" name="t" value={30} onChange={noop} minDigit={1} maxDigit={600} />);
        const input = screen.getByLabelText(/Время/);
        expect(input).toHaveAttribute("type", "number");
        expect(input).toHaveAttribute("min", "1");
        expect(input).toHaveAttribute("max", "600");
        expect(input).toHaveValue(30);
    });

    it("не ставит min/max, если не заданы, и принимает пустую строку", () => {
        render(<InputNumberField label="Время" name="t" value="" onChange={noop} />);
        const input = screen.getByLabelText(/Время/);
        expect(input).not.toHaveAttribute("min");
        expect(input).not.toHaveAttribute("max");
        expect(input).toHaveValue(null);
    });
});

describe("TextareaField", () => {
    it("null вместо строки не ломает поле", () => {
        render(<TextareaField label="Текст" name="t" value={null} onChange={noop} />);
        expect(screen.getByLabelText(/Текст/)).toHaveValue("");
    });

    it("rows по умолчанию 3 и пробрасывается", () => {
        const { rerender } = render(<TextareaField label="Текст" name="t" value="" onChange={noop} />);
        expect(screen.getByLabelText(/Текст/)).toHaveAttribute("rows", "3");
        rerender(<TextareaField label="Текст" name="t" value="" onChange={noop} rows={8} />);
        expect(screen.getByLabelText(/Текст/)).toHaveAttribute("rows", "8");
    });
});

describe("SelectField", () => {
    const make = (p: object = {}) => (
        <SelectField label="Категория" name="c" value={1} options={options} onChange={noop} {...p} />
    );

    it("сохраняет класс custom-select, а при ошибке добавляет is-invalid", () => {
        const { rerender } = render(make());
        expect(screen.getByLabelText(/Категория/)).toHaveClass("custom-select", "form-control");

        rerender(make({ error: "Выберите" }));
        expect(screen.getByLabelText(/Категория/)).toHaveClass("custom-select", "form-control", "is-invalid");
    });

    it("выбирает опцию по значению (число и строка совпадают)", () => {
        const { rerender } = render(make({ value: 1 }));
        expect(screen.getByLabelText(/Категория/)).toHaveValue("1");
        rerender(make({ value: "2" }));
        expect(screen.getByLabelText(/Категория/)).toHaveValue("2");
    });

    it.each([[null], [undefined], [99]])("значение %s без подходящей опции → пустой выбор", (value) => {
        render(make({ value }));
        expect(screen.getByLabelText(/Категория/)).toHaveValue("");
    });

    it("сохраняет нативный required и отключает пустую опцию у обязательного поля", () => {
        render(make({ isRequired: true }));
        expect(screen.getByLabelText(/Категория/)).toBeRequired();
        expect(screen.getByRole("option", { name: "Выберите значение" })).toBeDisabled();
    });

    it("необязательное поле: пустую опцию выбрать можно", () => {
        render(make());
        expect(screen.getByRole("option", { name: "Выберите значение" })).toBeEnabled();
    });

    it("isLoading блокирует поле и меняет текст пустой опции", () => {
        render(make({ isLoading: true }));
        expect(screen.getByLabelText(/Категория/)).toBeDisabled();
        expect(screen.getByRole("option", { name: "Загрузка…" })).toBeInTheDocument();
    });

    it("отключённая опция остаётся отключённой, onChange вызывается", () => {
        const onChange = vi.fn();
        render(make({ onChange }));
        expect(screen.getByRole("option", { name: "Два" })).toBeDisabled();
        fireEvent.change(screen.getByLabelText(/Категория/), { target: { value: "" } });
        expect(onChange).toHaveBeenCalledTimes(1);
    });

    // Фиксируем ТЕКУЩЕЕ поведение: `value && hasOption` считает 0 пустым значением.
    it("значение 0 считается пустым, даже если такая опция есть", () => {
        render(make({ value: 0, options: [{ value: 0, label: "Ноль" }] }));
        expect(screen.getByLabelText(/Категория/)).toHaveValue("");
    });
});
