<script setup lang="ts">
import Draggable from 'vuedraggable'
import type Question from '@/Models/Question'
import Options from '@/parts/template/TemplateInputOptions.vue'

defineProps<{
  showOptions: boolean
}>()

const question = defineModel<Question>({ required: true })
</script>

<template>
  <Draggable
    v-if="question.values"
    :list="question.values"
    handle=".handle"
    ghost-class="ghost"
    :animation="200"
  >
    <template #item="{ element, index }">
      <div class="d-flex align-center gap-4 mb-2">
        <div class="flex-shrink-0">
          <VCheckbox
            inline
            color="primary"
            density="compact"
          />
        </div>

        <div class="flex-grow-1">
          <VTextField
            v-model="element.label"
            :label="$t('attributes.option')"
          />
        </div>

        <div class="flex-shrink-0 flex-grow-0">
          <VTextField
            v-model.number="element.score"
            type="number"
            step="any"
            :label="$t('attributes.score')"
          />
        </div>

        <div class="flex-shrink-0">
          <VBtn
            variant="tonal"
            rounded="0"
            icon="tabler-arrows-move-vertical"
            size="x-small"
            class="handle me-2"
          />

          <VBtn
            variant="tonal"
            color="error"
            rounded="0"
            icon="tabler-x"
            size="x-small"
            @click="question.removeValues(index)"
          />
        </div>
      </div>
    </template>
  </Draggable>

  <VBtn
    block
    color="primary"
    variant="tonal"
    append-icon="tabler-plus"
    @click="question.addValues()"
  >
    {{ $t("labels.add_option") }}
  </VBtn>

  <Options
    v-if="showOptions"
    v-model="question"
    :has-score="false"
  />
</template>
