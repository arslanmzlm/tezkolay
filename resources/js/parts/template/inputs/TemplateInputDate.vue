<script setup lang="ts">
import type Question from '@/Models/Question'
import Options from '@/parts/template/TemplateInputOptions.vue'

defineProps<{
  showOptions: boolean
}>()

const question = defineModel<Question>({ required: true })
</script>

<template>
  <VTextField type="date" />

  <Options
    v-if="showOptions"
    v-model="question"
  />
</template>
