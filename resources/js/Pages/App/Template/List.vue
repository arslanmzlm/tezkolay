<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import BaseLayout from '@/layouts/BaseLayout.vue'
import Template from '@/Models/Template'
import SurveyInput from '@/parts/survey/SurveyInput.vue'
import Breadcrumb from '@/parts/app/Breadcrumb.vue'

const props = defineProps<{
  templates: Array<object>
}>()

const templates = props.templates.map(item => {
  return new Template(item)
})
</script>

<template>
  <Head :title="$t('titles.templates')" />

  <BaseLayout>
    <Breadcrumb :title="$t('titles.templates')">
      <VBtn :href="route('app.template.create')">
        {{ $t("models.template.add") }}
      </VBtn>
    </Breadcrumb>

    <VRow>
      <VCol cols="12">
        <VRow
          v-if="templates.length"
          key="isWorkspaceCollectionNotEmpty"
        >
          <VCol
            v-for="(template, index) in templates"
            :key="template.id ?? index"
            cols="12"
            lg="6"
            xl="4"
          >
            <VCard class="template-list-preview">
              <VCardText>
                <VRow>
                  <VCol
                    v-for="(question, questionIndex) in template.questions.getRenderAble().slice(0, 5)"
                    :key="questionIndex"
                    cols="12"
                  >
                    <SurveyInput
                      v-model="template.questions.items[questionIndex]"
                      :template
                      variant="outlined"
                    />
                  </VCol>
                </VRow>
              </VCardText>
              <VCardActions class="d-flex justify-space-between border-t pt-3">
                <div>
                  <h2>{{ template.name }}</h2>
                  <div>{{ template.description }}</div>
                </div>

                <div>
                  <VBtn
                    :href="route('app.template.edit', { template })"
                    variant="flat"
                    color="primary"
                    icon="tabler-edit"
                    size="small"
                  />

                  <VBtn
                    :href="route('app.template.show', { template })"
                    variant="flat"
                    color="info"
                    icon="tabler-eye"
                    size="small"
                  />
                </div>
              </VCardActions>
            </VCard>
          </VCol>
        </VRow>
      </VCol>
    </VRow>
  </BaseLayout>
</template>

<style lang="scss">
.template-list-preview {
  > .v-card-text {
    height: 500px;
    overflow: hidden;
  }
}
</style>
