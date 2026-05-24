import {ChangeEvent} from "react";
import {VerticalTextField} from "./components/vertical/VerticalTextField";
import {HorizontalTextField} from "./components/horizontal/HorizontalTextField";

type Props = {
    label: string,
    name: string,
    value: string,
    onChange: (e: ChangeEvent<HTMLInputElement>) => void,
    isRequired?: boolean,
    placeholder?: string,
    isVertical?: boolean,
};

export function InputTextField({
    label,
    name,
    value,
    onChange,
    isRequired,
    placeholder,
    isVertical = false,
}: Props) {

    return (
        isVertical ? (
            <VerticalTextField
                label={label}
                name={name}
                value={value}
                onChange={onChange}
                isRequired={isRequired}
                placeholder={placeholder}
            />
        ): (
            <HorizontalTextField
                label={label}
                name={name}
                value={value}
                onChange={onChange}
                isRequired={isRequired}
                placeholder={placeholder}
            />
        )
    );
}