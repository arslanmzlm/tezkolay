<script setup lang="ts">
import type Question from '@/Models/Question'

defineProps<{
  question: Question
}>()

const val = ref()
</script>

<template>
  <div
    v-for="(value, index) in question.values"
    :key="index"
  >
    <VCheckbox
      v-model="val"
      :value="index"
      :label="value.label"
    />
  </div>
</template>
