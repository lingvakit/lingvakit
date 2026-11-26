import { useId } from "react";
import { controlClass, firstError } from "./validation";
import type { FieldErrorValue } from "./validation";

type Options = {
    error?: FieldErrorValue;
    isRequired?: boolean;
    baseClassName?: string;
};

export function useFieldControl({
    error,
    isRequired = false,
    baseClassName,
}: Options = {}) {
    const controlId = useId();
    const errorId = `${controlId}-error`;
    const hasError = firstError(error) !== undefined;

    return {
        errorId,
        hasError,
        controlProps: {
            id: controlId,
            className: controlClass(hasError, baseClassName),
            "aria-required": isRequired || undefined,
            "aria-invalid": hasError || undefined,
            "aria-describedby": hasError ? errorId : undefined,
        },
    };
}
