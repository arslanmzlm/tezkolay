<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import BaseLayout from '@/layouts/BaseLayout.vue'
import Group from '@/Models/Group'
import Breadcrumb from '@/parts/app/Breadcrumb.vue'

const props = defineProps<{
  group: object
}>()

const group = reactive(new Group(props.group))
const form = useForm<Group>(group)

group.fillPatients()

function submit() {
  form.transform(() => group.getDataWithPatients())
  form.post(route('app.group.patients.update', { group }))
}
</script>

<template>
  <Head :title="$t('titles.patients')" />

  <BaseLayout>
    <Breadcrumb :title="$t('labels.group_patients_title', { workspace: group.workspace_name, group: group.name })" />

    <VRow>
      <VCol cols="12">
        <VCard>
          <VCardText>
            <form @submit.prevent="submit">
              <VRow>
                <VCol cols="12">
                  <VTextField
                    v-model="group.size"
                    type="number"
                    :label="$t('attributes.size')"
                    :error-messages="form.errors.size"
                    prepend-inner-icon="tabler-caret-up-down"
                    @change="group.fillPatients()"
                  />
                </VCol>

                <VCol cols="12">
                  <VAlert
                    color="error"
                    :title="$t('labels.warning')"
                    icon="tabler-alert-triangle-filled"
                    prominent
                  >
                    {{ $t("descriptions.changing_group_size") }}
                  </VAlert>
                </VCol>

                <VCol cols="12">
                  <VCard border>
                    <VVirtualScroll
                      :items="group.patients"
                      height="70vh"
                    >
                      <template #default="{ index, item }">
                        <div class="d-flex flex-column flex-xl-row gap-3 px-4 my-5">
                          <div class="row-index align-self-xl-center flex-shrink-0">
                            <b>{{ index + 1 }}.</b>
                          </div>

                          <VTextField
                            v-model="item.name"
                            :label="$t('attributes.name')"
                            class="flex-grow-1"
                            :error-messages="form.errors[`patients.${index}.name`]"
                          />

                          <VTextField
                            v-model="item.phone"
                            :label="$t('attributes.phone')"
                            class="flex-grow-1"
                            :error-messages="form.errors[`patients.${index}.phone`]"
                          />

                          <VTextField
                            v-model="item.contact_phone"
                            :label="$t('attributes.contact_phone')"
                            type="number"
                            class="flex-grow-1"
                            :error-messages="form.errors[`patients.${index}.contact_phone`]"
                          />

                          <VBtn
                            icon="tabler-x"
                            size="x-small"
                            color="error"
                            @click="group.removePatient(index)"
                          />
                        </div>
                      </template>
                    </VVirtualScroll>
                  </VCard>
                </VCol>

                <VCol cols="12">
                  <VBtn
                    block
                    color="primary"
                    variant="tonal"
                    append-icon="tabler-plus"
                    @click="group.addPatient()"
                  >
                    {{ $t("models.patient.add") }}
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

<style>
.row-index {
  width: 3rem;
}
</style>
