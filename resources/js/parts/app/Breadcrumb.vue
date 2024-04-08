<script setup lang="ts">
defineProps<{
  title: string
}>()
</script>

<template>
  <VRow>
    <VCol
      cols="12"
      :xl="$slots.default ? 6 : 12"
    >
      <h1 class="text-h1">
        {{ title }}
      </h1>
    </VCol>

    <VCol
      v-if="$slots.default"
      cols="12"
      lg="6"
      align-self="center"
      class="text-end"
    >
      <slot />
    </VCol>
  </VRow>
</template>
