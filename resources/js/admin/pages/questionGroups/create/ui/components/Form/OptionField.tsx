import {ChangeEvent} from "react";

type Props = {
    questionUuid: string;
    optionUuid: string
    value: string,
    checked: boolean,
    onTextChange: (
        optionUuid: string,
        value: string
    ) => void,
    onCheckedChange: (
        optionUuid: string
    ) => void
};

export function OptionField({
    questionUuid,
    optionUuid,
    value,
    checked,
    onTextChange,
    onCheckedChange
}: Props) {

    const handleTextChange = (
        e: ChangeEvent<HTMLInputElement>
    ): void => {
        onTextChange(optionUuid, e.target.value);
    }

    return (
        <div className="form-group row d-flex align-items-center mb-3">
            <div className="col-xl-10">
                <input
                    type="text"
                    className="form-control"
                    value={value}
                    onChange={handleTextChange}
                />
            </div>
            <div className="col-xl-2">
                <div className="mt-4">
                    <div className="styled-radio">
                        <input
                            type="radio"
                            className="input-is-correct"
                            id={`correct_${optionUuid}`}
                            name={`correct_${questionUuid}`}
                            checked={checked}
                            onChange={() => onCheckedChange(optionUuid)}
                        />
                        <label htmlFor={`correct_${optionUuid}`}></label>
                    </div>
                </div>
            </div>
        </div>
    );
}