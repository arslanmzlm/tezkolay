<script setup lang="ts">
import { ref } from 'vue'
import type Question from '@/Models/Question'

defineProps<{
  question: Question
}>()

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
</template>
