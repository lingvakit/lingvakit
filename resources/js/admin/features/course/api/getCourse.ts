import {type LoaderFunctionArgs, redirect} from "react-router-dom";
import type {Course} from "../types/course";

type ApiResponse<T> = { data: T };

export async function getCourse({ params }: LoaderFunctionArgs) {
    const id = params.id;
    if (!id) throw new Response("Missing id", { status: 400 });

    const res = await fetch(`/react/api/courses/${id}`, {
        method: "GET",
        credentials: "include",
        headers: { Accept: "application/json" },
    });

    if (res.status === 401) {
        throw redirect("/login");
    }

    if (!res.ok) {
        const text = await res.text().catch(() => "");
        throw new Response(text || "Request failed", { status: res.status });
    }

    const json = (await res.json()) as ApiResponse<Course>;
    return json.data;
}