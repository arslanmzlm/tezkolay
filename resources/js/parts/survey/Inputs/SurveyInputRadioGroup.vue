<script setup lang="ts">
import type Question from '@/Models/Question'

const question = defineModel<Question>({ required: true })
</script>

<template>
  <VRadioGroup v-model="question.value">
    <VRadio
      v-for="(value, index) in question.values"
      :key="index"
      :label="value.label"
      :value="index"
    />
  </VRadioGroup>
</template>
