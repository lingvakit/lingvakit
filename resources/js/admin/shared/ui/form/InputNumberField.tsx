import {ChangeEvent} from "react";
import {VerticalNumberField} from "./components/vertical/VerticalNumberField";
import {HorizontalNumberField} from "./components/horizontal/HorizontalNumberField";

type Props = {
    label: string,
    name: string,
    value: number,
    onChange: (e: ChangeEvent<HTMLInputElement>) => void,
    isRequired?: boolean,
    placeholder?: string,
    minDigit?: number,
    maxDigit?: number,
    isVertical?: boolean,
};

export function InputNumberField({
    label,
    name,
    value,
    onChange,
    isRequired,
    placeholder,
    minDigit,
    maxDigit,
    isVertical = false,
}: Props) {
    return (
        isVertical ? (
            <VerticalNumberField
                label={label}
                name={name}
                value={value}
                onChange={onChange}
                isRequired={isRequired}
                placeholder={placeholder}
                maxDigit={minDigit}
                minDigit={maxDigit}
            />
        ) : (
            <HorizontalNumberField
                label={label}
                name={name}
                value={value}
                onChange={onChange}
                isRequired={isRequired}
                placeholder={placeholder}
                minDigit={minDigit}
                maxDigit={maxDigit}
            />
        )
    );
}