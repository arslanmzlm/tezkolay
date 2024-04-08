<script setup lang="ts">
import type Question from '@/Models/Question'

const question = defineModel<Question>({ required: true })

const position = question.value.getOption('image_position', 'top')
</script>

<template>
  <div
    class="description-input d-flex gap-4"
    :class="position"
  >
    <div
      class="description-body"
      v-html="question.value"
    />

    <div
      v-if="question.getOption('image')"
      class="description-image"
    >
      <img
        :src="question.getOptionImage()"
        :alt="$t('labels.description_image')"
        class="img-fluid"
      >
    </div>
  </div>
</template>

<style lang="scss">
.description-body > *:last-child {
  margin-bottom: 0;
}

.description-image img {
  max-width: 100%;
}

.description-input {
  &.top,
  &.bottom {
    flex-direction: column;
  }

  &.left,
  &.right {
    flex-direction: row;

    .description-image {
      flex-shrink: 0;
      width: 50%;
    }
  }

  &.top,
  &.left {
    .description-body {
      order: 1;
    }

    .description-image {
      order: 0;
    }
  }

  &.bottom,
  &.right {
    .description-body {
      order: 0;
    }

    .description-image {
      order: 1;
    }
  }
}
</style>
