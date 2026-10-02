import type {PropsWithChildren, ReactNode} from 'react';
import {AuthLogo} from "./AuthLogo";
import {AuthFooter} from "./AuthFooter";

interface Props {
    title: string;
    subtitle?: string;
    footer?: ReactNode;
}

export function AuthLayout({title, subtitle, footer, children}: PropsWithChildren<Props>) {
    return (
        <div className="auth">
            <main className="auth__main">
                <AuthLogo/>

                <section className="auth__card">
                    <h1 className="auth__title">{title}</h1>
                    {subtitle && <p className="auth__subtitle">{subtitle}</p>}
                    {children}
                    {footer && <div className="auth__footer">{footer}</div>}
                </section>
            </main>

            <AuthFooter/>
        </div>
    );
}