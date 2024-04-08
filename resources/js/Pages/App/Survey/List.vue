<script setup lang="ts">
import BaseLayout from '@/layouts/BaseLayout.vue'
import SurveyCard from '@/parts/app/items/SurveyCard.vue'
import Group from '@/Models/Group'

const props = defineProps<{
  groups: Array<object>
}>()

const groups = props.groups.map(item => {
  return new Group(item)
})
</script>

<template>
  <BaseLayout :title="$t('titles.surveys')">
    <VRow>
      <template
        v-for="group in groups"
        :key="group.id"
      >
        <template v-if="group.surveys">
          <VCol
            v-for="(survey, index) in group.surveys"
            :key="survey.id ?? index"
            cols="12"
            lg="6"
            xl="4"
          >
            <SurveyCard
              :group
              :survey
            />
          </VCol>
        </template>
      </template>
    </VRow>
  </BaseLayout>
</template>
