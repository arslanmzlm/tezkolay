import './bootstrap'

// Styles
import '@core/scss/template/index.scss'
import '@styles/styles.scss'
import 'vue-toastification/dist/index.css'

import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import Toast from 'vue-toastification'
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import { registerPlugins } from '@core/utils/plugins'

import { ToastDefaults } from '@/Helpers/Toast'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: title => `${title} - ${appName}`,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    // eslint-disable-next-line vue/component-api-style
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(autoAnimatePlugin)
      .use(Toast, ToastDefaults)

    registerPlugins(app)

    app.mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})
