import type { ChangeEvent, ReactNode } from "react";
import { FieldLayout } from "./FieldLayout";
import { useFieldControl } from "./useFieldControl";
import type { FieldErrorValue } from "./validation";

export type SelectOption = {
    value: string | number;
    label: string;
    disabled?: boolean;
};

type Props = {
    label: string;
    name: string;
    value: string | number | null | undefined;
    options: readonly SelectOption[];
    onChange: (e: ChangeEvent<HTMLSelectElement>) => void;
    isRequired?: boolean;
    disabled?: boolean;
    isLoading?: boolean;
    placeholder?: string;
    error?: FieldErrorValue;
    children?: ReactNode;
};

export function SelectField({
    label,
    name,
    value,
    options,
    onChange,
    isRequired = false,
    disabled = false,
    isLoading = false,
    placeholder = "Выберите значение",
    error,
    children,
}: Props) {
    const { controlProps, errorId } = useFieldControl({
        error,
        isRequired,
        baseClassName: "custom-select form-control",
    });

    const hasOption = options.some(
        (option) => String(option.value) === String(value),
    );
    const selectValue = value && hasOption ? String(value) : "";

    return (
        <FieldLayout
            label={label}
            htmlFor={controlProps.id}
            isRequired={isRequired}
            error={error}
            errorId={errorId}
            footer={children}
        >
            <select
                {...controlProps}
                name={name}
                value={selectValue}
                onChange={onChange}
                required={isRequired}
                disabled={disabled || isLoading}
            >
                <option value="" disabled={isRequired}>
                    {isLoading ? "Загрузка…" : placeholder}
                </option>

                {options.map((option) => (
                    <option
                        key={option.value}
                        value={option.value}
                        disabled={option.disabled}
                    >
                        {option.label}
                    </option>
                ))}
            </select>
        </FieldLayout>
    );
}
