import type { Params } from "react-router-dom";

export type Breadcrumb = {
    label: string;
    to?: string
};

export type BreadcrumbHandle = {
    title?: string;
    breadcrumb?: (args: {
        params: Params<string>;
        data: unknown }
    ) => Breadcrumb | null;
};