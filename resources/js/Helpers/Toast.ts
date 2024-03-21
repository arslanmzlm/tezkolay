import type { TYPE } from 'vue-toastification'
import { POSITION, useToast } from 'vue-toastification'
import type { ToastOptions } from 'vue-toastification/dist/types/types'

export const ToastDefaults = {
  position: POSITION.BOTTOM_CENTER,
  timeout: 4000,
  closeOnClick: true,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  showCloseButtonOnHover: false,
  closeButton: 'button',
  icon: true,
}

export function toast(message: string, type: TYPE, options: ToastOptions = {}) {
  requestAnimationFrame(() => {
    const toastInstance = useToast()

    toastInstance(message, { type, ...options })
  })
}
