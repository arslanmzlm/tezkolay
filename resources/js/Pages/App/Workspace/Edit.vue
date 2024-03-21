<script setup lang="ts">
import { reactive, ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import Workspace from '@/Models/Workspace'
import BaseLayout from '@/layouts/BaseLayout.vue'
import WorkspaceForm from '@/parts/app/forms/WorkspaceForm.vue'
import WorkspaceCard from '@/parts/app/items/WorkspaceCard.vue'

const props = defineProps<{
  workspace: Workspace
}>()

const workspace = reactive(new Workspace(props.workspace))
const form = useForm<Workspace>(workspace)
const logo = ref<any>(workspace.logoSrc)

function update() {
  form.transform(() => workspace.data)
  form.post(route('app.workspace.update', workspace))
}
</script>

<template>
  <Head :title="$t('models.workspace.edit')" />

  <BaseLayout>
    <VRow>
      <VCol
        cols="12"
        lg="7"
      >
        <WorkspaceForm
          key="workspaceFormEdit"
          v-model:logo="logo"
          :workspace
          :form
          @submit="update"
        />
      </VCol>

      <VCol
        cols="12"
        lg="5"
      >
        <WorkspaceCard
          :workspace
          :logo
        />
      </VCol>
    </VRow>
  </BaseLayout>
</template>
