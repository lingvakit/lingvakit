type Props<T extends string> = {
    title: string,
    name: string,
    currentValue: string,
    onChange: (value: T) => void,
    items: Array<{
        value: T,
        label: string,
    }>;
};

export function InputRadioField<T extends string>({
    title,
    name,
    currentValue,
    onChange,
    items,
}: Props<T>) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <div className="col-lg-3 form-control-label">
                {title}
            </div>
            <div className="col-lg-9">
                <div className="row">
                    {items.map((item, key) => {
                        const id = `${name}_${item.value}`;

                        return (
                            <div key={key} className="col-xl-2">
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
                                        <label htmlFor={id}>
                                            {item.label}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        )
                    })}
                </div>
            </div>
        </div>
    );
}