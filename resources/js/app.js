import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from 'ziggy-js';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import Aura from '@primeuix/themes/aura';
import 'primeicons/primeicons.css';

createInertiaApp({
    title: (title) => `${title} - AgroSystem`,

    resolve: name => {
        const pages = import.meta.glob('../vue/**/*.vue', { eager: true })
        return pages[`../vue/pages/${name}.vue`]
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        darkModeSelector: '.dark',
                    }
                }
            })
            .use(ToastService)
            .use(ConfirmationService)
            .use(ZiggyVue)
            .mount(el)
    },
})