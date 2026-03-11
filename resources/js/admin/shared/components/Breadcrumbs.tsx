import {Link, type UIMatch, useMatches} from "react-router-dom";
import type {Breadcrumb, BreadcrumbHandle} from "../types/router";

export default function Breadcrumbs() {
    const matches = useMatches() as UIMatch<unknown, BreadcrumbHandle>[];

    const crumbs: Breadcrumb[] = [{ label: "Home", to: "/admin" }];

    for (const m of matches) {
        const bcFn = m.handle?.breadcrumb;

        if (typeof bcFn === "function") {
            const item = bcFn({ params: m.params, data: m.data });
            if (item) crumbs.push(item);
        }
    }

    return (
        <ul className="breadcrumb">
            {crumbs.map((c, idx) => {
                const isLast = idx === crumbs.length - 1;
                const isHome = c.label === "Home";

                return (
                    <li key={`${c.label}-${c.to ?? idx}`} className={`breadcrumb-item ${isLast ? "active" : ""}`}>
                        {c.to && !isLast ? (
                            <Link to={c.to}>{isHome ? <i className="ti ti-home" /> : c.label}</Link>
                        ) : (
                            isHome ? <i className="ti ti-home" /> : c.label
                        )}
                    </li>
                );
            })}
        </ul>
    );
}