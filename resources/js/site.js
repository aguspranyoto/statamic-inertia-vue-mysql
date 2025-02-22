import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "vuetify/styles";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const vuetify = createVuetify({
    components,
    directives,
});

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .use(Toast)
            .mount(el);
    },
});
