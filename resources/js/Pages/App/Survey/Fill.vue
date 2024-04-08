<script setup lang="ts">
import { reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'
import BaseLayout from '@/layouts/BaseLayout.vue'
import SurveyInput from '@/parts/survey/SurveyInput.vue'
import Survey from '@/Models/Survey'

const props = defineProps<{
  survey: object
  surveyItem: object
}>()

const survey = reactive(new Survey(props.survey))
const form = useForm<Survey>(survey)

provide('template', survey)

function submit() {
  form.transform(() => survey.getAnswerData())
  form.post(route('app.survey.item.update', { surveyItem: props.surveyItem }))
}
</script>

<template>
  <BaseLayout :title="$t('titles.survey')">
    <form @submit.prevent="submit">
      <VRow v-if="survey">
        <template
          v-for="(question, index) in survey.questions.items"
          :key="index"
        >
          <VCol
            v-if="question.isRenderAble"
            cols="12"
          >
            <SurveyInput v-model="survey.questions.items[index]" />
          </VCol>
        </template>
        <VCol cols="12">
          <VCard>
            <VCardText class="text-end">
              <VBtn
                theme="primary"
                type="submit"
              >
                {{ $t('labels.submit') }}
              </VBtn>
            </VCardText>
          </VCard>
        </VCol>
      </VRow>
    </form>
  </BaseLayout>
</template>
