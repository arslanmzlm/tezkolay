<script setup lang="ts">
import type Workspace from '@/Models/Workspace'

defineProps<{
  workspace: Workspace
}>()
</script>

<template>
  <VCard class="workspace-item">
    <VCardItem>
      <VRow>
        <VCol
          cols="12"
          lg="3"
        >
          <div class="d-flex flex-column h-100 rounded border pa-4">
            <div class="mb-2">
              <img
                v-if="workspace.logo"
                class="workspace-logo"
                :src="workspace.logoSrc"
                :alt="$t('alts.workspace_logo')"
              >
              <VAvatar
                v-else
                :size="64"
                color="secondary"
                variant="tonal"
              >
                <VIcon size="36">
                  tabler-color-swatch
                </VIcon>
              </VAvatar>
            </div>
            <h2 class="text-h2 mb-5">
              {{ workspace.name }}
            </h2>
            <div class="d-flex justify-end gap-2 mt-auto">
              <VBtn
                :href="route('app.workspace.edit', { workspace })"
                :title="$t('labels.edit')"
                size="small"
                icon="tabler-edit"
              />
            </div>
          </div>
        </VCol>

        <VCol
          cols="12"
          lg="9"
        >
          <VRow>
            <VCol
              v-for="(group, index) in workspace.groups"
              :key="group.id ?? index"
              cols="12"
              lg="6"
            >
              <div class="rounded border pa-4">
                <div class="d-flex justify-space-between mb-3">
                  <div>
                    <h3 class="text-h3 mb-2">
                      {{ group.name }}
                    </h3>
                    <div class="mb-1">
                      {{ $t("labels.group_size") }}: <b>{{ group.size }}</b>
                    </div>
                    <div class="mb-1">
                      {{ $t("labels.saved_patient_count") }}: <b>{{ group.patients_count ?? 0 }}</b>
                    </div>
                    <div>
                      {{ $t("labels.survey_count") }}: <b>{{ group.surveys_count ?? 0 }}</b>
                    </div>
                  </div>

                  <VAvatar
                    :size="48"
                    color="info"
                  >
                    <VIcon :size="26">
                      tabler-users-group
                    </VIcon>
                  </VAvatar>
                </div>
                <div class="d-flex justify-end gap-2">
                  <VBtn
                    :href="route('app.group.patients.edit', { group })"
                    color="warning"
                  >
                    {{ $t("titles.patients") }}
                  </VBtn>

                  <VBtn
                    :href="route('app.group.surveys.edit', { group })"
                    color="success"
                  >
                    {{ $t("titles.surveys") }}
                  </VBtn>
                </div>
              </div>
            </VCol>
          </VRow>
        </VCol>
      </VRow>
    </VCardItem>
  </VCard>
</template>

<style scoped lang="scss">
.workspace-item {
    .workspace-logo {
        max-width: 100%;
        max-height: 200px;
    }

    .group-item {
        display: flex;
        justify-content: space-between;
    }
}
</style>
