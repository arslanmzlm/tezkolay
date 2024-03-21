<script setup lang="ts">
import type Question from '@/Models/Question'

defineProps<{
  question: Question
}>()
</script>

<template>
  <VTextField type="date" />
</template>
