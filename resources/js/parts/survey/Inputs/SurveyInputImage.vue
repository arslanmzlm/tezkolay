<script setup lang="ts">
import type Question from '@/Models/Question'

const question = defineModel<Question>({ required: true })
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
