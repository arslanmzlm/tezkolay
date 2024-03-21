<script setup lang="ts">
import type Question from '@/Models/Question'

withDefaults(defineProps<{
  hasRequire?: boolean
  hasDescription?: boolean
  hasScore?: boolean
  canStore?: boolean
}>(), {
  hasRequire: true,
  hasDescription: true,
  hasScore: true,
  canStore: true,
})

const question = defineModel<Question>({ required: true })
</script>

<template>
  <div class="mt-5 rounded border pa-4">
    <VRow>
      <VCol cols="12">
        <div class="option-row">
          <VTextField
            v-model.number="question.order"
            type="number"
            disabled
            :label="$t('attributes.order')"
          />
        </div>
      </VCol>

      <VCol
        v-if="hasRequire"
        cols="12"
      >
        <div class="option-row">
          <VCheckbox
            v-model="question.required"
            :label="$t('attributes.required')"
          />
        </div>
      </VCol>

      <VCol
        v-if="hasScore"
        cols="12"
      >
        <div class="option-row">
          <VTextField
            v-model.number="question.score"
            type="number"
            step="any"
            :label="$t('attributes.score')"
          />
        </div>
      </VCol>

      <VCol
        v-if="hasDescription"
        cols="12"
      >
        <div class="option-row">
          <VTextarea
            v-model="question.description"
            :label="$t('attributes.description')"
            :placeholder="$t('descriptions.question_description')"
          />
        </div>
      </VCol>

      <slot />
    </VRow>
  </div>
</template>
