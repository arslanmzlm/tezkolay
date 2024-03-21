<script setup lang="ts">
import { provide, reactive } from 'vue'
import { Head } from '@inertiajs/vue3'
import Template from '@/Models/Template'
import BaseLayout from '@/layouts/BaseLayout.vue'
import SurveyInput from '@/parts/survey/SurveyInput.vue'

const props = defineProps<{
  template: object
}>()

const template = reactive(new Template(props.template))

provide('template', template)
</script>

<template>
  <Head :title="$t('models.template.preview')" />

  <BaseLayout>
    <VRow v-if="template">
      <VCol>
        <div class="text-center">
          <h1 class="text-h1">
            {{ template.name }}
          </h1>
          <p class="mt-2">
            {{ template.description }}
          </p>
        </div>
      </VCol>

      <VCol
        v-for="(question, index) in template.questions.getRenderAble()"
        :key="index"
        cols="12"
      >
        <SurveyInput :question />
      </VCol>
    </VRow>
  </BaseLayout>
</template>
