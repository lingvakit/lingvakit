import { render, screen } from "@testing-library/react";
import { FieldLayout } from "../FieldLayout";

describe("FieldLayout", () => {
    it("горизонтально: label col-lg-3, контент в col-lg-9", () => {
        const { container } = render(<FieldLayout label="L"><i data-testid="c" /></FieldLayout>);
        expect(container.querySelector("label.col-lg-3.form-control-label")).not.toBeNull();
        expect(container.querySelector(".col-lg-9 [data-testid=c]")).not.toBeNull();
    });

    it("вертикально: всё внутри col-12", () => {
        const { container } = render(<FieldLayout layout="vertical" label="L"><i /></FieldLayout>);
        expect(container.querySelector(".col-12 > label.form-control-label")).not.toBeNull();
        expect(container.querySelector(".col-lg-3")).toBeNull();
    });

    it("звёздочка для обязательного поля скрыта от скринридеров", () => {
        render(<FieldLayout label="L" isRequired><i /></FieldLayout>);
        expect(screen.getByText("*")).toHaveAttribute("aria-hidden", "true");
    });

    it("порядок: контент → ошибка → footer", () => {
        render(
            <FieldLayout label="L" error="Ошибка" footer={<b data-testid="f" />}>
                <i data-testid="c" />
            </FieldLayout>,
        );
        const [c, e, f] = [screen.getByTestId("c"), screen.getByText("Ошибка"), screen.getByTestId("f")];
        expect(c.compareDocumentPosition(e) & Node.DOCUMENT_POSITION_FOLLOWING).toBeTruthy();
        expect(e.compareDocumentPosition(f) & Node.DOCUMENT_POSITION_FOLLOWING).toBeTruthy();
    });

    it("group: правая колонка именована заголовком", () => {
        render(<FieldLayout label="Тип" group="group"><i /></FieldLayout>);
        expect(screen.getByRole("group", { name: "Тип" })).toHaveClass("col-lg-9");
    });

    it("radiogroup: помечается aria-invalid только при ошибке", () => {
        const { rerender } = render(<FieldLayout label="Тип" labelAs="div" group="radiogroup"><i /></FieldLayout>);
        expect(screen.getByRole("radiogroup", { name: "Тип" })).not.toHaveAttribute("aria-invalid");

        rerender(<FieldLayout label="Тип" labelAs="div" group="radiogroup" error="Выберите"><i /></FieldLayout>);
        expect(screen.getByRole("radiogroup")).toHaveAttribute("aria-invalid", "true");
    });

    it("group игнорируется в вертикальной раскладке", () => {
        render(<FieldLayout layout="vertical" label="L" group="group"><i /></FieldLayout>);
        expect(screen.queryByRole("group")).toBeNull();
    });

    it("labelAs=div не создаёт <label>", () => {
        const { container } = render(<FieldLayout label="L" labelAs="div"><i /></FieldLayout>);
        expect(container.querySelector("label")).toBeNull();
        expect(container.querySelector("div.col-lg-3.form-control-label")).not.toBeNull();
    });
});
