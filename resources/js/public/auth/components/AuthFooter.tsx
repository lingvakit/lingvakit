import {COMPANY_NAME, LEGAL_LINKS} from '../config';

export function AuthFooter() {
    const year = new Date().getFullYear();

    return (
        <footer className="auth__legal">
            <span>© {year} {COMPANY_NAME}. Все права защищены.</span>
            {LEGAL_LINKS.map((link) => (
                <a key={link.href} href={link.href} target="_blank" rel="noreferrer">
                    {link.label}
                </a>
            ))}
        </footer>
    );
}