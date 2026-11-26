import { FieldLayout } from "./FieldLayout";
import type { FieldErrorValue } from "./validation";

type Props<T extends string> = {
    title: string;
    name: string;
    currentValue: string;
    onChange: (value: T) => void;
    items: Array<{
        value: T;
        label: string;
    }>;
    error?: FieldErrorValue;
};

export function InputRadioField<T extends string>({
    title,
    name,
    currentValue,
    onChange,
    items,
    error,
}: Props<T>) {
    return (
        <FieldLayout
            label={title}
            labelAs="div"
            group="radiogroup"
            error={error}
        >
            <div className="row">
                {items.map((item) => {
                    const id = `${name}_${item.value}`;

                    return (
                        <div key={item.value} className="col-xl-2">
                            <div className="mb-3">
                                <div className="styled-radio">
                                    <input
                                        type="radio"
                                        name={name}
                                        id={id}
                                        value={item.value}
                                        checked={currentValue === item.value}
                                        onChange={() => onChange(item.value)}
                                    />
                                    <label htmlFor={id}>{item.label}</label>
                                </div>
                            </div>
                        </div>
                    );
                })}
            </div>
        </FieldLayout>
    );
}
