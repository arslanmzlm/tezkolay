<script setup lang="ts">
import { inject } from 'vue'
import type Template from '@/Models/Template'
import type Question from '@/Models/Question'

defineProps<{
  question: Question
}>()

const template = inject<Template>('template')
</script>

<template>
  <div
    v-if="question.getOption('title')"
    class="text-lg font-weight-bold"
  >
    {{ question.getOption("title") }}
  </div>

  <table v-if="template" class="w-100">
    <thead>
      <tr>
        <td />
        <td
          v-for="(value, index) in question.values"
          :key="index"
          class="py-3 text-center"
        >
          {{ value.label }}
        </td>
      </tr>
    </thead>

    <tbody>
      <tr
        v-for="(quest, index) in template.questions.getRelated(question)"
        :key="quest.order ?? index"
      >
        <td class="py-2">
          {{ `${$t("labels.survey_question_order", { order: quest.question_order })} ${quest.label}` }}
        </td>
        <td
          v-for="(value, valueIndex) in quest.values"
          :key="valueIndex"
          class="py-2 text-center"
        >
          <VRadioGroup v-model="quest.value">
            <VRadio
              :value="valueIndex"
              class="justify-center"
            />
          </VRadioGroup>
        </td>
      </tr>
    </tbody>
  </table>
</template>
