import {ChangeEvent} from "react";
import {VerticalTextareaField} from "./components/vertical/VerticalTextareaField";
import {HorizontalTextareaField} from "./components/horizontal/HorizontalTextareaField";

type Props = {
    label: string,
    name: string,
    value: string,
    onChange: (e: ChangeEvent<HTMLTextAreaElement>) => void,
    isRequired?: boolean,
    placeholder?: string,
    rows?: number,
    isVertical?: boolean,
};

export function TextareaField({
    label,
    name,
    value,
    onChange,
    isRequired = false,
    placeholder = '',
    rows = 3,
    isVertical = false,
}: Props) {
    return (
        isVertical ? (
            <VerticalTextareaField
                label={label}
                name={name}
                value={value}
                onChange={onChange}
                rows={rows}
                isRequired={isRequired}
                placeholder={placeholder}
            />
        ) : (
            <HorizontalTextareaField
                label={label}
                name={name}
                value={value}
                onChange={onChange}
                rows={rows}
                isRequired={isRequired}
                placeholder={placeholder}
            />
        )
    );
}
