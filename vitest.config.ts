import { fileURLToPath, URL } from "node:url";
import { defineConfig } from "vitest/config";

export default defineConfig({
    resolve: {
        alias: { "@admin": fileURLToPath(new URL("./resources/js/admin", import.meta.url)) },
    },
    test: { environment: "jsdom", globals: true, setupFiles: ["./vitest.setup.ts"] },
});
