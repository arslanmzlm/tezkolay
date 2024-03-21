<script setup lang="ts">
import { ref } from 'vue'
import type Question from '@/Models/Question'
import Options from '@/parts/template/TemplateInputOptions.vue'

defineProps<{
  showOptions: boolean
}>()

const question = defineModel<Question>({ required: true })

if (question.value.options === null)
  question.value.options = {}

const value = ref(0)
</script>

<template>
  <VSlider
    v-model="value"
    :min="question.getOption('min', 0)"
    :max="question.getOption('max', 100)"
    :step="1"
    thumb-label="always"
  />

  <Options
    v-if="showOptions"
    v-model="question"
  >
    <VCol
      v-if="question.options"
      cols="12"
    >
      <div class="option-row">
        <VTextField
          v-model="question.options.min"
          type="number"
          :label="$t('attributes.min')"
        />
      </div>
    </VCol>

    <VCol
      v-if="question.options"
      cols="12"
    >
      <div class="option-row">
        <VTextField
          v-model="question.options.max"
          type="number"
          :label="$t('attributes.max')"
        />
      </div>
    </VCol>
  </Options>
</template>
