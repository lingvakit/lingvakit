import { useId } from "react";
import type { ReactNode } from "react";
import { FieldError } from "./FieldError";
import { firstError } from "./validation";
import type { FieldErrorValue } from "./validation";

export type FieldLayoutType = "horizontal" | "vertical";

type Props = {
    layout?: FieldLayoutType;
    label: string;
    htmlFor?: string;
    labelAs?: "label" | "div";
    group?: "group" | "radiogroup";
    isRequired?: boolean;
    error?: FieldErrorValue;
    errorId?: string;
    footer?: ReactNode;
    children: ReactNode;
};

export function FieldLayout({
    layout = "horizontal",
    label,
    htmlFor,
    labelAs = "label",
    group,
    isRequired = false,
    error,
    errorId,
    footer,
    children,
}: Props) {
    const labelId = useId();
    const horizontal = layout === "horizontal";
    const grouped = horizontal && group !== undefined;
    const labelClassName = horizontal
        ? "col-lg-3 form-control-label"
        : "form-control-label";

    const labelContent = (
        <>
            {label}
            {isRequired && (
                <span className="text-danger ml-2" aria-hidden="true">
                    *
                </span>
            )}
        </>
    );

    const labelNode =
        labelAs === "div" ? (
            <div id={grouped ? labelId : undefined} className={labelClassName}>
                {labelContent}
            </div>
        ) : (
            <label
                id={grouped ? labelId : undefined}
                htmlFor={htmlFor}
                className={labelClassName}
            >
                {labelContent}
            </label>
        );

    const body = (
        <>
            {children}
            <FieldError id={errorId} error={error} />
            {footer}
        </>
    );

    return (
        <div className="form-group row d-flex align-items-center mb-5">
            {horizontal ? (
                <>
                    {labelNode}
                    <div
                        className="col-lg-9"
                        role={grouped ? group : undefined}
                        aria-labelledby={grouped ? labelId : undefined}
                        aria-invalid={
                            group === "radiogroup" &&
                            firstError(error) !== undefined
                                ? true
                                : undefined
                        }
                    >
                        {body}
                    </div>
                </>
            ) : (
                <div className="col-12">
                    {labelNode}
                    {body}
                </div>
            )}
        </div>
    );
}
