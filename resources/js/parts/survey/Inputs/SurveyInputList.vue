<script setup lang="ts">
import { computed, ref } from 'vue'
import type Question from '@/Models/Question'
import { LIST_ORDERED_STYLES, LIST_STYLE } from '@core/enums'

const props = defineProps<{
  question: Question
}>()

const listStyle = ref(props.question.getOption('list_style', LIST_STYLE.DISC))

const listTag = computed<string>(() => {
  return LIST_ORDERED_STYLES.includes(listStyle.value) ? 'ol' : 'ul'
})
</script>

<template>
  <component
    :is="listTag"
    class="ps-6"
    :style="{ listStyleType: listStyle }"
  >
    <li
      v-for="(value, index) in question.values"
      :key="index"
      class="mb-2"
    >
      {{ value.label }}
    </li>
  </component>
</template>
