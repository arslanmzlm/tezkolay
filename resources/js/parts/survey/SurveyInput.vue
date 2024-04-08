<script setup lang="ts">
/* eslint-disable */
import type Question from '@/Models/Question'
import {inject} from "vue";
import Template from "@/Models/Template";

const props = defineProps<{
  template?: Template
  variant?: NonNullable<"flat" | "text" | "elevated" | "tonal" | "outlined" | "plain">
}>()

const question = defineModel<Question>({ required: true })

let template = inject<Template | false>("template", false)

if (!template && typeof props.template !== 'undefined') {
  template = props.template
  provide('template', template)
}
</script>

<script lang="ts">
import SurveyInputDate from '@/parts/survey/Inputs/SurveyInputDate.vue'
import SurveyInputText from '@/parts/survey/Inputs/SurveyInputText.vue'
import SurveyInputDescription from '@/parts/survey/Inputs/SurveyInputDescription.vue'
import SurveyInputImage from '@/parts/survey/Inputs/SurveyInputImage.vue'
import SurveyInputList from '@/parts/survey/Inputs/SurveyInputList.vue'
import SurveyInputCheckboxGroup from '@/parts/survey/Inputs/SurveyInputCheckboxGroup.vue'
import SurveyInputNumber from '@/parts/survey/Inputs/SurveyInputNumber.vue'
import SurveyInputMultipleRadioGroup from '@/parts/survey/Inputs/SurveyInputMultipleRadioGroup.vue'
import SurveyInputRange from '@/parts/survey/Inputs/SurveyInputRange.vue'
import SurveyInputRadioGroup from '@/parts/survey/Inputs/SurveyInputRadioGroup.vue'

export default {
  components: {
    SurveyInputDate,
    SurveyInputText,
    SurveyInputDescription,
    SurveyInputImage,
    SurveyInputList,
    SurveyInputCheckboxGroup,
    SurveyInputNumber,
    SurveyInputMultipleRadioGroup,
    SurveyInputRange,
    SurveyInputRadioGroup,
  },
}
</script>

<template>
  <VCard :variant="props.variant">
    <VCardTitle v-if="question.labelShowAble">
       <span v-if="question.question_order">{{
           $t("labels.survey_question_order", {
             order: question.question_order,
           })
         }}</span>
      {{ question.label }}
      <span v-if="question.required" class="text-error" :title="$t('labels.required_attribute')">*</span>
    </VCardTitle>
    <VCardText>
      <component
        :is="`SurveyInput${question.component}`"
        v-model="question"
      />

      <div
        v-if="question.description"
        key="isQuestionHasDescription"
        class="mt-3 text-sm"
      >
        {{ question.description }}
      </div>
    </VCardText>
  </VCard>
</template>
