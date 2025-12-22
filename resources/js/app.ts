import '../css/app.css';
// Load saved theme on startup
const savedTheme = localStorage.getItem('theme')

if (savedTheme === 'dark') {
  document.documentElement.classList.add('dark')
}

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';
import { createHead } from '@vueuse/head';



const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const head = createHead();

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) });
        
        vueApp.use(plugin);
        vueApp.use(head); // ← подключаем head провайдер

        vueApp.mount(el);
    },
         progress: false
});

// This will set light / dark mode on page load...
initializeTheme();
