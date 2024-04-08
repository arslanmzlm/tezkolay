<script setup lang="ts">
import type Question from '@/Models/Question'

const question = defineModel<Question>({ required: true })
</script>

<template>
  <VTextField v-model="question.value" />
</template>
