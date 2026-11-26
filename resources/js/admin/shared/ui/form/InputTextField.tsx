import type { ChangeEvent, ReactNode } from "react";
import { FieldLayout } from "./FieldLayout";
import { useFieldControl } from "./useFieldControl";
import type { FieldErrorValue } from "./validation";

type Props = {
    label: string;
    name: string;
    value: string;
    onChange: (e: ChangeEvent<HTMLInputElement>) => void;
    isRequired?: boolean;
    placeholder?: string;
    isVertical?: boolean;
    error?: FieldErrorValue;
    children?: ReactNode;
};

export function InputTextField({
    label,
    name,
    value,
    onChange,
    isRequired,
    placeholder,
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
            <input
                {...controlProps}
                type="text"
                name={name}
                placeholder={placeholder}
                value={value}
                onChange={onChange}
            />
        </FieldLayout>
    );
}
