import { fileURLToPath } from 'node:url'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { VueRouterAutoImports } from 'unplugin-vue-router'
import { defineConfig } from 'vite'
import VueDevTools from 'vite-plugin-vue-devtools'
import Layouts from 'vite-plugin-vue-layouts'
import vuetify from 'vite-plugin-vuetify'
import laravel from 'laravel-vite-plugin'
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    laravel({
      input: 'resources/js/app.ts',
      refresh: true,
    }),

    vue({
      template: {
        compilerOptions: {
          isCustomElement: tag => tag === 'swiper-container' || tag === 'swiper-slide',
        },
      },
    }),
    VueDevTools(),
    vueJsx(),

    // Docs: https://github.com/vuetifyjs/vuetify-loader/tree/master/packages/vite-plugin
    vuetify({
      styles: {
        configFile: 'resources/js/assets/styles/variables/_vuetify.scss',
      },
    }),

    // Docs: https://github.com/johncampionjr/vite-plugin-vue-layouts#vite-plugin-vue-layouts
    Layouts({
      layoutsDirs: './resources/js/layouts/',
    }),

    // Docs: https://github.com/antfu/unplugin-vue-components#unplugin-vue-components
    Components({
      dirs: ['resources/js/@core/components', 'resources/js/views/demos', 'resources/js/components'],
      dts: true,
      resolvers: [
        componentName => {
          // Auto import `VueApexCharts`
          if (componentName === 'VueApexCharts')
            return { name: 'default', from: 'vue3-apexcharts', as: 'VueApexCharts' }
        },
      ],
    }),

    // Docs: https://github.com/antfu/unplugin-auto-import#unplugin-auto-import
    AutoImport({
      imports: ['vue', VueRouterAutoImports, '@vueuse/core', '@vueuse/math', 'vue-i18n', 'pinia'],
      dirs: [
        './resources/js/@core/utils',
        './resources/js/@core/composable/',
        './resources/js/composables/',
        './resources/js/utils/',
        './resources/js/plugins/*/composables/*',
      ],
      vueTemplate: true,

      // ℹ️ Disabled to avoid confusion & accidental usage
      ignore: ['useCookies', 'useStorage'],
    }),

    // Docs: https://github.com/intlify/bundle-tools/tree/main/packages/unplugin-vue-i18n#intlifyunplugin-vue-i18n
    VueI18nPlugin({
      runtimeOnly: false,
      compositionOnly: true,
      include: [
        fileURLToPath(new URL('./src/plugins/i18n/locales/**', import.meta.url)),
      ],
    }),
  ],
  define: { 'process.env': {} },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
      '@themeConfig': fileURLToPath(new URL('./themeConfig.ts', import.meta.url)),
      '@core': fileURLToPath(new URL('./resources/js/@core', import.meta.url)),
      '@layouts': fileURLToPath(new URL('./resources/js/@layouts', import.meta.url)),
      '@images': fileURLToPath(new URL('./resources/js/assets/images/', import.meta.url)),
      '@styles': fileURLToPath(new URL('./resources/js/assets/styles/', import.meta.url)),
      '@configured-variables': fileURLToPath(new URL('./resources/js/assets/styles/variables/_template.scss', import.meta.url)),
      'apexcharts': fileURLToPath(new URL('node_modules/apexcharts-clevision', import.meta.url)),
      '@db': fileURLToPath(new URL('./resources/js/plugins/fake-api/handlers/', import.meta.url)),
      '@api-utils': fileURLToPath(new URL('./resources/js/plugins/fake-api/utils/', import.meta.url)),
    },
  },
  build: {
    chunkSizeWarningLimit: 5000,
  },
  optimizeDeps: {
    exclude: ['vuetify'],
    entries: [
      './resources/js/**/*.vue',
    ],
  },
})
