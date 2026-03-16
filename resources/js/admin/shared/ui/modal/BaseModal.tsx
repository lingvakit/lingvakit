import React, {useEffect} from "react";

type Props = {
    isOpen: boolean;
    title: string;
    onClose: () => void;
    children: React.ReactNode;
};

export default function BaseModal({ isOpen, title, onClose, children }: Props) {
    useEffect(() => {
        const handleKeyDown = (e: KeyboardEvent) => {
            if (e.key === "Escape") {
                onClose();
            }
        }

        document.addEventListener("keydown", handleKeyDown);

        if (isOpen) {
            document.body.classList.add("modal-open");
        } else {
            document.body.classList.remove("modal-open");
        }

        return () => {
            document.body.classList.remove("modal-open");
            document.removeEventListener("keydown", handleKeyDown);
        };
    }, [isOpen, onClose]);

    if (!isOpen) {
        return null;
    }

    return (
        <div
            className="modal fade show"
            style={{ display: "block" }}
            onClick={onClose}
        >
            <div
                className="modal-dialog modal-dialog-centered"
                onClick={(e) => e.stopPropagation()}
            >
                <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">{title}</h4>

                        <button
                            type="button"
                            className="close"
                            onClick={onClose}
                        >
                            <span aria-hidden="true">×</span>
                            <span className="sr-only">close</span>
                        </button>
                    </div>

                    <div className="modal-body">
                        {children}
                    </div>
                </div>
            </div>
        </div>
    );
}
