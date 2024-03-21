<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import BaseLayout from '@/layouts/BaseLayout.vue'
import Workspace from '@/Models/Workspace'
import WorkspaceItem from '@/parts/app/items/WorkspaceItem.vue'

const props = defineProps<{
  workspaces: Array<object>
}>()

const workspaces = props.workspaces.map(item => {
  return new Workspace(item)
})
</script>

<template>
  <Head :title="$t('titles.workspaces')" />

  <BaseLayout>
    <VRow>
      <VCol
        cols="12"
        lg="6"
      >
        <h1 class="text-h1">
          {{ $t("titles.workspaces") }}
        </h1>
      </VCol>

      <VCol
        cols="12"
        lg="6"
        align-self="center"
        class="text-end"
      >
        <VBtn :href="route('app.workspace.create')">
          {{ $t("models.workspace.add") }}
        </VBtn>
      </VCol>

      <VCol cols="12">
        <VRow
          v-if="workspaces.length"
          key="isWorkspaceCollectionNotEmpty"
        >
          <VCol
            v-for="(workspace, index) in workspaces"
            :key="workspace.id ?? index"
            cols="12"
          >
            <WorkspaceItem :workspace />
          </VCol>
        </VRow>
      </VCol>
    </VRow>
  </BaseLayout>
</template>
