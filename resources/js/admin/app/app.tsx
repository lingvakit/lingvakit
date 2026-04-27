import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import {RouterProvider} from "react-router-dom";
import {router} from "./routes";
import 'ckeditor5/ckeditor5.css';


const container = document.getElementById("react-root");

if (container) {
    createRoot(container).render(
        <StrictMode>
            <RouterProvider router={router} />
        </StrictMode>
    );
}