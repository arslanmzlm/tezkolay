<script setup lang="ts">
import BaseLayout from '@/layouts/BaseLayout.vue'
import Survey from "@/Models/Survey";
import {router} from "@inertiajs/vue3";
import {VDataTableServer} from "vuetify/labs/components";
import Group from "@/Models/Group";
import Patient from "@/Models/Patient";
import {getI18n} from "@/plugins/i18n";

const {t} = getI18n().global

const props = defineProps<{
  survey: object
  patients: any
}>()

const survey = new Survey(props.survey)

const headers = [
  {title: '#', key: 'id'},
  {title: t('attributes.name'), key: 'name'},
  {title: t('attributes.phone'), key: 'phone'},
  {title: t('attributes.contact_phone'), key: 'contact_phone'},
  {title: t('attributes.state'), key: 'survey_item.stateLabel'},
  {title: '', key: 'actions'},
];

const loading = ref(false)

function loadItems(paginationInfo: Record<string, any>) {
  console.log(paginationInfo)
  router.get(
    route('app.survey.show', {survey}),
    {
      page: paginationInfo.page,
      per_page: paginationInfo.itemsPerPage
    },
    {
      only: ['patients'],
      preserveState: true,
      onBefore: () => {
        loading.value = true
      },
      onFinish: () => {
        props.patients.data = props.patients.data.map(item => {
          return new Patient(item)
        })
        loading.value = false
      }
    }
  )
}
</script>

<template>
  <BaseLayout :title="$t('titles.survey')">
    <VCard>
      <VDataTableServer :items-per-page="patients.per_page"
                        :items-length="patients.total"
                        :items="patients.data"
                        item-value="id"
                        :headers
                        :loading
                        height="50vh"
                        @update:options="loadItems">
        <template #item.survey_item.stateLabel="{ value, item }">
          <VChip v-if="value" :color="item.survey_item.stateColor">
            {{ value }}
          </VChip>
        </template>
      </VDataTableServer>
    </VCard>
  </BaseLayout>
</template>
