<script setup lang="ts">
/* eslint-disable */
import type Question from '@/Models/Question'
import {inject} from "vue";
import Template from "@/Models/Template";

const props = defineProps<{
  question: Question,
  template?: Template
  variant?: NonNullable<"flat" | "text" | "elevated" | "tonal" | "outlined" | "plain">
}>()

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
    </VCardTitle>
    <VCardText>
      <component
        :is="`SurveyInput${question.component}`"
        :question="question"
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
