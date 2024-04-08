<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import { DateTime } from 'luxon'
import BaseLayout from '@/layouts/BaseLayout.vue'
import Group from '@/Models/Group'
import Breadcrumb from '@/parts/app/Breadcrumb.vue'

const componentProps = defineProps<{
  group: object
  templates: Array<object>
}>()

const group = reactive(new Group(componentProps.group))
const form = useForm<Group>(group)

const flatPickrConfigs = {
  locale: 'tr',
  altInput: true,
  altFormat: 'j F Y',
  minDate: DateTime.now().plus({ day: 1 }).toISODate(),
}

function submit() {
  form.transform(() => group.getDataWithSurveys())
  form.post(route('app.group.surveys.update', { group }))
}
</script>

<template>
  <Head :title="$t('titles.surveys')" />

  <BaseLayout>
    <Breadcrumb :title="$t('labels.group_surveys_title', { workspace: group.workspace_name, group: group.name })" />

    <VRow>
      <VCol cols="12">
        <VCard>
          <VCardText>
            <form @submit.prevent="submit">
              <VRow>
                <VCol
                  v-auto-animate
                  cols="12"
                >
                  <div
                    v-for="(survey, index) in group.surveys"
                    :key="index"
                    class="d-flex flex-column flex-xl-row gap-3 px-4 my-5"
                  >
                    <div class="row-index align-self-xl-center flex-shrink-0">
                      <b>{{ index + 1 }}.</b>
                    </div>

                    <VTextField
                      v-model="survey.name"
                      :label="$t('attributes.name')"
                      class="flex-grow-1 flex-shrink-0"
                      :error-messages="form.errors[`surveys.${index}.name`]"
                    />

                    <VAutocomplete
                      v-model="survey.template_id"
                      :items="templates"
                      item-title="name"
                      item-value="id"
                      :label="$t('attributes.template')"
                      class="flex-grow-1 flex-shrink-0"
                      :disabled="!survey.isEditable"
                      :error-messages="form.errors[`surveys.${index}.template_id`]"
                    >
                      <template #item="{ props, item }">
                        <VListItem
                          v-bind="props"
                          :title="item.raw?.name"
                          :subtitle="item.raw?.description"
                          append-icon="tabler-link"
                        >
                          <template #append>
                            <VBtn
                              icon="tabler-external-link"
                              variant="text"
                              :color="survey.template_id === item.raw.id ? 'white' : 'primary'"
                              size="small"
                              :title="$t('models.template.preview')"
                              :href="route('app.template.show', { template: item.raw })"
                              target="_blank"
                              rel="noopener noreferrer"
                            />
                          </template>
                        </VListItem>
                      </template>
                    </VAutocomplete>

                    <div class="flex-grow-1 flex-shrink-0">
                      <AppDateTimePicker
                        v-model="survey.survey_at"
                        :placeholder="$t('attributes.survey_at')"
                        :config="flatPickrConfigs"
                        :disabled="!survey.isEditable"
                        :error-messages="form.errors[`surveys.${index}.survey_at`]"
                      />
                    </div>

                    <div class="row-buttons order-0">
                      <VBtn
                        v-if="survey.isDeletable"
                        icon="tabler-x"
                        size="x-small"
                        color="error"
                        @click="group.removeSurvey(index)"
                      />
                    </div>
                  </div>
                </VCol>

                <VCol cols="12">
                  <VBtn
                    block
                    color="primary"
                    variant="tonal"
                    append-icon="tabler-plus"
                    @click="group.addSurvey()"
                  >
                    {{ $t("models.survey.add") }}
                  </VBtn>
                </VCol>

                <VCol
                  cols="12"
                  class="text-end"
                >
                  <VBtn
                    color="primary"
                    type="submit"
                    :disabled="form.processing"
                  >
                    {{ $t("labels.submit") }}
                  </VBtn>
                </VCol>
              </VRow>
            </form>
          </VCardText>
        </VCard>
      </VCol>
    </VRow>
  </BaseLayout>
</template>

<style lang="scss">
.row-index {
  width: 1rem;
}

.row-buttons {
  width: 3rem;
}
</style>
