import {useEffect, useState} from "react";

export function useDebounce<T>(value: T, delay = 500): T {
    const [debounce, setDebounce] = useState(value);

    useEffect(() => {
        const timeoutId = setTimeout(() => setDebounce(value), delay);
        return () => clearTimeout(timeoutId);
    }, [value, delay]);

    return debounce;
}
