import { render } from "@testing-library/react";
import { FieldError } from "../FieldError";
import { controlClass, firstError } from "../validation";

describe("firstError", () => {
    it.each([
        ["text", "text"],
        [["a", "b"], "a"],
        [[], undefined],
        ["", undefined],
        [[""], undefined],
        [null, undefined],
        [undefined, undefined],
    ])("firstError(%j) → %j", (input, expected) => {
        expect(firstError(input as never)).toBe(expected);
    });
});

describe("controlClass", () => {
    it("добавляет is-invalid только при ошибке", () => {
        expect(controlClass(false)).toBe("form-control");
        expect(controlClass(true)).toBe("form-control is-invalid");
    });

    it("поддерживает свой базовый класс (select)", () => {
        expect(controlClass(true, "custom-select form-control")).toBe("custom-select form-control is-invalid");
    });
});

describe("FieldError", () => {
    it("ничего не рисует без сообщения", () => {
        const { container } = render(<FieldError error={undefined} />);
        expect(container).toBeEmptyDOMElement();
    });

    it("рисует первое сообщение с нужным id", () => {
        const { getByText } = render(<FieldError id="err" error={["Ошибка", "Другая"]} />);
        expect(getByText("Ошибка")).toHaveAttribute("id", "err");
        expect(getByText("Ошибка")).toHaveClass("invalid-feedback", "d-block");
    });
});
