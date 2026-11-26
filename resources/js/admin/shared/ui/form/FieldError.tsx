import { firstError } from "./validation";
import type { FieldErrorValue } from "./validation";

type Props = {
    error: FieldErrorValue;
    id?: string;
};

export function FieldError({ error, id }: Props) {
    const message = firstError(error);

    if (!message) {
        return null;
    }

    return (
        <div id={id} className="invalid-feedback d-block">
            {message}
        </div>
    );
}
