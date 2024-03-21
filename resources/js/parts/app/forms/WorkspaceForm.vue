<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type Workspace from '@/Models/Workspace'
import type { FileResult } from '@/Helpers/Upload'

const props = defineProps<{
  workspace: Workspace
  form: InertiaForm<Workspace>
}>()

const emits = defineEmits(['submit'])

const workspace = props.workspace
const form = props.form
const logo = defineModel<FileResult>('logo')

async function fileSelected(event: Event) {
  try {
    logo.value
            = await workspace.setLogoFile(event) ?? null
  }
  catch {
    removeLogo()
  }
}

function removeLogo() {
  logo.value = null
  workspace.logo = null
}
</script>

<template>
  <VCard>
    <VCardItem>
      <form @submit.prevent="emits('submit')">
        <VRow>
          <VCol cols="12">
            <AppTextField
              v-model="workspace.name"
              name="name"
              :label="$t('attributes.name')"
              prepend-inner-icon="tabler-color-swatch"
              :error-messages="form.errors.name"
            />
          </VCol>

          <VCol cols="12">
            <VFileInput
              accept="image/*"
              name="logo"
              :label="$t('attributes.logo')"
              :error-messages="form.errors.logo"
              :prepend-icon="null"
              prepend-inner-icon="tabler-photo"
              @input="fileSelected"
              @click:clear="removeLogo"
            />
          </VCol>

          <VCol
            v-if="workspace.groups && workspace.groups.length"
            cols="12"
          >
            <VCard
              v-auto-animate
              border
            >
              <div
                v-for="(group, index) in workspace.groups"
                :key="index"
                class="d-flex gap-3 px-4 my-5"
              >
                <VTextField
                  v-model="group.name"
                  :label="$t('attributes.group_name')"
                  class="w-50 p-3"
                  :error-messages="form.errors[`groups.${index}.name`]"
                />

                <VTextField
                  v-model.number="group.size"
                  :label="$t('attributes.group_size')"
                  type="number"
                  class="w-50 p-3"
                  :error-messages="form.errors[`groups.${index}.size`]"
                />

                <VBtn
                  icon="tabler-x"
                  size="x-small"
                  color="error"
                  @click="workspace.removeGroup(index)"
                />
              </div>
            </VCard>
          </VCol>

          <VCol cols="12">
            <VBtn
              block
              color="primary"
              variant="tonal"
              append-icon="tabler-plus"
              @click="workspace.addGroup()"
            >
              {{ $t("models.group.add") }}
            </VBtn>
          </VCol>

          <VCol
            v-if="form.errors.groups"
            cols="12"
          >
            <VAlert
              variant="tonal"
              type="error"
            >
              {{ form.errors.groups }}
            </VAlert>
          </VCol>

          <VCol
            cols="12"
            class="text-end"
          >
            <VBtn
              type="submit"
              :disabled="form.processing"
            >
              {{ $t("labels.submit") }}
            </VBtn>
          </VCol>
        </VRow>
      </form>
    </VCardItem>
  </VCard>
</template>
