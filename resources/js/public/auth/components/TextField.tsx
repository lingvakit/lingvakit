import {useId, useState, type InputHTMLAttributes} from 'react';

interface Props extends Omit<InputHTMLAttributes<HTMLInputElement>, 'onChange'> {
    label: string;
    error?: string;
    onChange: (value: string) => void;
}

export function TextField({label, error, onChange, type = 'text', ...rest}: Props) {
    const id = useId();
    const [visible, setVisible] = useState(false);
    const isPassword = type === 'password';

    return (
        <div className={`field${error ? ' field--error' : ''}`}>
            <label htmlFor={id}>{label}</label>
            <div className="field__control">
                <input
                    id={id}
                    type={isPassword && visible ? 'text' : type}
                    aria-invalid={!!error}
                    aria-describedby={error ? `${id}-err` : undefined}
                    onChange={(e) => onChange(e.target.value)}
                    {...rest}
                />
                {isPassword && (
                    <button type="button" className="field__toggle" onClick={() => setVisible((v) => !v)}>
                        {visible ? 'Скрыть' : 'Показать'}
                    </button>
                )}
            </div>
            {error && <small id={`${id}-err`} className="field__error">{error}</small>}
        </div>
    );
}