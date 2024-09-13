import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/site.css", "resources/js/site.js"],
            refresh: true,
        }),
        vue(),
    ],
});
