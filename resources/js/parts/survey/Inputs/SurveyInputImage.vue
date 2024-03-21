<script setup lang="ts">
import type Question from '@/Models/Question'

defineProps<{
  question: Question
}>()
</script>

<template>
  <div v-if="question.value">
    <img
      :src="question.getValueImage()"
      :alt="question.label ?? ''"
      class="img-fluid"
    >
  </div>
</template>
