<script setup lang="ts">
/* eslint-disable */
import { inject, ref } from 'vue'
import type Question from '@/Models/Question'
import type Template from '@/Models/Template'

defineProps<{
  index: number
}>()

const question = defineModel<Question>({ required: true })

const showOptions = ref(false)

const template = inject<Template>('template')
</script>

<script lang="ts">
import TemplateInputDate from '@/parts/template/inputs/TemplateInputDate.vue'
import TemplateInputText from '@/parts/template/inputs/TemplateInputText.vue'
import TemplateInputDescription from '@/parts/template/inputs/TemplateInputDescription.vue'
import TemplateInputImage from '@/parts/template/inputs/TemplateInputImage.vue'
import TemplateInputList from '@/parts/template/inputs/TemplateInputList.vue'
import TemplateInputCheckboxGroup from '@/parts/template/inputs/TemplateInputCheckboxGroup.vue'
import TemplateInputNumber from '@/parts/template/inputs/TemplateInputNumber.vue'
import TemplateInputOptions from '@/parts/template/TemplateInputOptions.vue'
import TemplateInputMultipleRadioGroup from '@/parts/template/inputs/TemplateInputMultipleRadioGroup.vue'
import TemplateInputRange from '@/parts/template/inputs/TemplateInputRange.vue'
import TemplateInputRadioGroup from '@/parts/template/inputs/TemplateInputRadioGroup.vue'

export default {
  components: {
    TemplateInputDate,
    TemplateInputText,
    TemplateInputDescription,
    TemplateInputImage,
    TemplateInputList,
    TemplateInputCheckboxGroup,
    TemplateInputNumber,
    TemplateInputOptions,
    TemplateInputMultipleRadioGroup,
    TemplateInputRange,
    TemplateInputRadioGroup,
  },
}
</script>

<template>
  <div class="template-input position-relative mb-5 rounded border pa-4 sortable-item">
    <div class="template-input-buttons position-absolute">
      <VBtn
        icon
        variant="text"
        rounded="0"
        size="small"
        :color="showOptions ? 'primary' : 'secondary'"
        @click="showOptions = !showOptions"
      >
        <VIcon size="x-large">
          tabler-settings
        </VIcon>
      </VBtn>

      <VBtn
        icon
        class="handle"
        variant="text"
        rounded="0"
        size="small"
        color="warning"
      >
        <VIcon size="x-large">
          tabler-arrows-move-vertical
        </VIcon>
      </VBtn>

      <VBtn
        icon
        variant="text"
        rounded="0"
        size="small"
        color="error"
        @click="template.questions.remove(question)"
      >
        <VIcon size="x-large">
          tabler-x
        </VIcon>
      </VBtn>
    </div>

    <div :class="{ 'pt-4': !question.labelShowAble }">
      <div
        v-if="question.labelShowAble"
        class="d-flex mb-4 gap-3"
      >
        <div
          v-if="question.question_order"
          class="align-self-end border-b"
        >
          {{
            $t("labels.question_order", {
              order: question.question_order,
            })
          }}
        </div>

        <VTextField
          v-model="question.label"
          variant="underlined"
          :placeholder="$t('placeholders.type_question_label_or_title')"
        />
      </div>

      <component
        :is="`TemplateInput${question.component}`"
        v-model="question"
        :show-options="showOptions"
      />
    </div>
  </div>
</template>

<style>
.template-input-buttons {
  top: 0;
  right: 2rem;
  z-index: 1;
}
</style>
