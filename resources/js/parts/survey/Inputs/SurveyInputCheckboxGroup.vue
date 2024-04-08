<script setup lang="ts">
import type Question from '@/Models/Question'

const question = defineModel<Question>({ required: true })
if (!question.value.value)
  question.value.value = []
</script>

<template>
  <div
    v-for="(value, index) in question.values"
    :key="index"
  >
    <VCheckbox
      v-model="question.value"
      :value="index"
      :label="value.label"
    />
  </div>
</template>
