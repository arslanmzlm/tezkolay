<script setup lang="ts">
import type Question from '@/Models/Question'

defineProps<{
  question: Question
}>()

const val = ref()
</script>

<template>
  <VRadioGroup v-model="val">
    <VRadio
      v-for="(value, index) in question.values"
      :key="index"
      :label="value.label"
      :value="index"
    />
  </VRadioGroup>
</template>
