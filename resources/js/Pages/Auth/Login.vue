<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import { useGenerateImageVariant } from '@core/composable/useGenerateImageVariant'
import authV2LoginIllustrationBorderedDark from '@images/pages/auth-v2-login-illustration-bordered-dark.png'
import authV2LoginIllustrationBorderedLight from '@images/pages/auth-v2-login-illustration-bordered-light.png'
import authV2LoginIllustrationDark from '@images/pages/auth-v2-login-illustration-dark.png'
import authV2LoginIllustrationLight from '@images/pages/auth-v2-login-illustration-light.png'
import authV2MaskDark from '@images/pages/misc-mask-dark.png'
import authV2MaskLight from '@images/pages/misc-mask-light.png'
import { VNodeRenderer } from '@layouts/components/VNodeRenderer'
import { themeConfig } from '@themeConfig'
import Blank from '@/layouts/BlankLayout.vue'

definePage({
  meta: {
    layout: 'blank',
  },
})

const form = useForm({
  username: '',
  password: '',
})

const submit = () => {
  form.post(route('login'))
}

const isPasswordVisible = ref(false)

const authThemeImg = useGenerateImageVariant(
  authV2LoginIllustrationLight,
  authV2LoginIllustrationDark,
  authV2LoginIllustrationBorderedLight,
  authV2LoginIllustrationBorderedDark,
  true)

const authThemeMask = useGenerateImageVariant(authV2MaskLight, authV2MaskDark)
</script>

<template>
  <Head :title="$t('titles.login')" />

  <Blank>
    <VRow
      no-gutters
      class="auth-wrapper bg-surface"
    >
      <VCol
        md="8"
        class="d-none d-md-flex"
      >
        <div class="position-relative bg-background rounded-lg w-100 ma-8 me-0">
          <div class="d-flex align-center justify-center w-100 h-100">
            <VImg
              max-width="505"
              :src="authThemeImg"
              class="auth-illustration mt-16 mb-2"
            />
          </div>

          <VImg
            class="auth-footer-mask"
            :src="authThemeMask"
          />
        </div>
      </VCol>

      <VCol
        cols="12"
        md="4"
        class="auth-card-v2 d-flex align-center justify-center"
      >
        <VCard
          flat
          :max-width="500"
          class="mt-12 mt-sm-0 pa-4"
        >
          <VCardText>
            <VNodeRenderer
              :nodes="themeConfig.app.logo"
              class="mb-6"
            />
            <h4 class="text-h4 mb-1">
              Welcome to <span class="text-capitalize">{{ themeConfig.app.title }}</span>! 👋🏻
            </h4>
            <p class="mb-0">
              Please sign-in to your account and start the adventure
            </p>
          </VCardText>
          <VCardText>
            <VForm @submit.prevent="submit">
              <VRow>
                <!-- username -->
                <VCol cols="12">
                  <AppTextField
                    v-model="form.username"
                    autofocus
                    label="Kullanıcı Adı"
                    placeholder="kullanıcı"
                    type="text"
                    :error-messages="form.errors.username"
                  />
                </VCol>

                <!-- password -->
                <VCol cols="12">
                  <AppTextField
                    v-model="form.password"
                    label="Şifre"
                    placeholder="············"
                    :error-messages="form.errors.password"
                    :type="isPasswordVisible ? 'text' : 'password'"
                    :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                    @click:append-inner="isPasswordVisible = !isPasswordVisible"
                  />

                  <div class="mt-4">
                    <VBtn
                      block
                      type="submit"
                    >
                      Giriş Yap
                    </VBtn>
                  </div>
                </VCol>
              </VRow>
            </VForm>
          </VCardText>
        </VCard>
      </VCol>
    </VRow>
  </Blank>
</template>

<style lang="scss">
@use "@core/scss/template/pages/page-auth";
</style>
