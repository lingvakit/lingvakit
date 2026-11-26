import type { ChangeEvent, ReactNode } from "react";
import { FieldLayout } from "./FieldLayout";
import { useFieldControl } from "./useFieldControl";
import type { FieldErrorValue } from "./validation";

type Props = {
    label: string;
    name: string;
    value: string | null;
    onChange: (e: ChangeEvent<HTMLTextAreaElement>) => void;
    isRequired?: boolean;
    placeholder?: string;
    rows?: number;
    isVertical?: boolean;
    error?: FieldErrorValue;
    children?: ReactNode;
};

export function TextareaField({
    label,
    name,
    value,
    onChange,
    isRequired = false,
    placeholder = "",
    rows = 3,
    isVertical = false,
    error,
    children,
}: Props) {
    const { controlProps, errorId } = useFieldControl({ error, isRequired });

    return (
        <FieldLayout
            layout={isVertical ? "vertical" : "horizontal"}
            label={label}
            htmlFor={controlProps.id}
            isRequired={isRequired}
            error={error}
            errorId={errorId}
            footer={children}
        >
            <textarea
                {...controlProps}
                name={name}
                rows={rows}
                placeholder={placeholder}
                value={value ?? ""}
                onChange={onChange}
            />
        </FieldLayout>
    );
}
