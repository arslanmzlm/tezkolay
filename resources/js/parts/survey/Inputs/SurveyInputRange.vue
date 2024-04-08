<script setup lang="ts">
import type Question from '@/Models/Question'

const question = defineModel<Question>({ required: true })
</script>

<template>
  <VSlider
    v-model="question.value"
    :min="question.getOption('min', 0)"
    :max="question.getOption('max', 100)"
    :step="1"
    thumb-label="always"
  />
</template>
