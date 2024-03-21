<script setup lang="ts">
import { useTheme } from 'vuetify'
import { usePage } from '@inertiajs/vue3'
import { TYPE } from 'vue-toastification'
import ScrollToTop from '@core/components/ScrollToTop.vue'
import initCore from '@core/initCore'
import { initConfigStore, useConfigStore } from '@core/stores/config'
import { hexToRgb } from '@layouts/utils'
import Default from '@/layouts/Default.vue'
import type { PageProps } from '@/types'
import { toast } from '@/Helpers/Toast'

const { global } = useTheme()

// ℹ️ Sync current theme with initial loader theme
initCore()
initConfigStore()

const configStore = useConfigStore()

const page = usePage<PageProps>()

if (page.props.toast) {
  let message: string
  let type: TYPE

  if (typeof page.props.toast === 'string') {
    message = page.props.toast
    type = TYPE.SUCCESS
  }
  else {
    message = page.props.toast.message
    type
            = Object.values(TYPE).includes(page.props.toast.type)
        ? page.props.toast.type
        : TYPE.SUCCESS
  }

  toast(message, type)
}
</script>

<template>
  <VLocaleProvider :rtl="configStore.isAppRTL">
    <!-- ℹ️ This is required to set the background color of active nav link based on currently active global theme's primary -->
    <VApp :style="`--v-global-theme-primary: ${hexToRgb(global.current.value.colors.primary)}`">
      <Default>
        <slot />
      </Default>

      <ScrollToTop />
    </VApp>
  </VLocaleProvider>
</template>
