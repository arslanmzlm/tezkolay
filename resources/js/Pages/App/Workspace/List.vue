<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import BaseLayout from '@/layouts/BaseLayout.vue'
import Workspace from '@/Models/Workspace'
import WorkspaceItem from '@/parts/app/items/WorkspaceItem.vue'
import Breadcrumb from '@/parts/app/Breadcrumb.vue'

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
    <Breadcrumb :title="$t('titles.workspaces')">
      <VBtn :href="route('app.workspace.create')">
        {{ $t("models.workspace.add") }}
      </VBtn>
    </Breadcrumb>

    <VRow>
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
