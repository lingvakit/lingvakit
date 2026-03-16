import { isRouteErrorResponse, useRouteError, Link } from "react-router-dom";

export default function ErrorPage() {
    const error = useRouteError();

    if (isRouteErrorResponse(error)) {
        return (
            <div style={{ padding: 24 }}>
                <h1>{error.status} {error.statusText}</h1>
                <p>{typeof error.data === "string" ? error.data : "Страница не найдена"}</p>
                <Link to="/admin">На главную админки</Link>
            </div>
        );
    }

    return (
        <div style={{ padding: 24 }}>
            <h1>Unexpected error</h1>
            <pre>{error instanceof Error ? error.message : String(error)}</pre>
            <Link to="/admin">На главную админки</Link>
        </div>
    );
}