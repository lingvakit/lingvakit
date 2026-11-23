import { useId } from "react";
import type { ChangeEvent, ReactNode } from "react";

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
    error?: string;
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
    const id = useId();
    const errorId = `${id}-error`;

    const hasOption = options.some(
        (option) => String(option.value) === String(value),
    );
    const selectValue = value && hasOption ? String(value) : "";

    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label htmlFor={id} className="col-lg-3 form-control-label">
                {label}
                {isRequired && <span className="text-danger"> *</span>}
            </label>

            <div className="col-lg-9">
                <select
                    id={id}
                    name={name}
                    className={`custom-select form-control${error ? " is-invalid" : ""}`}
                    value={selectValue}
                    onChange={onChange}
                    required={isRequired}
                    disabled={disabled || isLoading}
                    aria-invalid={error ? true : undefined}
                    aria-describedby={error ? errorId : undefined}
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

                {error && (
                    <div id={errorId} className="invalid-feedback d-block">
                        {error}
                    </div>
                )}

                {children}
            </div>
        </div>
    );
}
