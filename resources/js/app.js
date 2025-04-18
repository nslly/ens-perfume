import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3'; // Correct adapter for Vue 3
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import '../css/app.css';


createInertiaApp({
    title: title => `${title} - Ensperfume`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});