<script setup lang="ts">
import { inject } from 'vue'
import Draggable from 'vuedraggable'
import type Template from '@/Models/Template'
import type Question from '@/Models/Question'
import Options from '@/parts/template/TemplateInputOptions.vue'

defineProps<{
  showOptions: boolean
}>()

const template = inject<Template>('template')

const question = defineModel<Question>({ required: true })

if (question.value.options === null)
  question.value.options = {}
</script>

<template>
  <VTextField
    v-if="question.options"
    v-model="question.options.title"
    variant="underlined"
    class="mb-4"
    :placeholder="$t('placeholders.type_multiple_question_title')"
  />

  <VRow v-if="template">
    <VCol
      cols="12"
      lg="6"
    >
      <div class="border rounded pa-5">
        <div
          v-for="(quest, index) in template.questions.getRelates(question)"
          :key="quest.order ?? index"
          class="d-flex align-center gap-4 mb-2"
        >
          <div class="flex-shrink-0">
            <VCheckbox
              v-model="quest.required"
              inline
              color="primary"
              density="compact"
              :title="$t('attributes.required')"
            />
          </div>

          <div class="flex-shrink-1 flex-grow-0">
            {{ $t("labels.question_order", { order: quest.question_order }) }}
          </div>

          <div class="flex-grow-1">
            <VTextField
              v-model="quest.label"
              :label="$t('attributes.question')"
            />
          </div>

          <div class="flex-shrink-0">
            <VBtn
              variant="tonal"
              color="error"
              rounded="0"
              icon="tabler-x"
              size="x-small"
              @click="template.questions.remove(quest)"
            />
          </div>
        </div>

        <VBtn
          block
          color="primary"
          variant="tonal"
          append-icon="tabler-plus"
          @click="template.questions.addRelated(question)"
        >
          {{ $t("labels.add_question") }}
        </VBtn>
      </div>
    </VCol>

    <VCol
      cols="12"
      lg="6"
    >
      <div class="border rounded pa-5">
        <Draggable
          v-if="question.values"
          :list="question.values"
          class="grow space-y-4"
          handle=".handle"
          ghost-class="ghost"
          :animation="200"
        >
          <template #item="{ element, index }">
            <div class="d-flex align-center gap-4 mb-2">
              <div class="flex-shrink-0">
                <VRadio
                  inline
                  color="primary"
                  density="compact"
                />
              </div>

              <div class="flex-grow-1">
                <VTextField
                  v-model="element.label"
                  :label="$t('attributes.answer')"
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
          {{ $t("labels.add_answer") }}
        </VBtn>
      </div>
    </VCol>
  </VRow>

  <Options
    v-if="showOptions"
    v-model="question"
    :has-score="false"
    :has-require="false"
    :can-store="false"
  />
</template>
