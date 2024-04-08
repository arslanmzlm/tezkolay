<script setup lang="ts">
import { reactive, ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import Workspace from '@/Models/Workspace'
import BaseLayout from '@/layouts/BaseLayout.vue'
import WorkspaceForm from '@/parts/app/forms/WorkspaceForm.vue'
import WorkspaceCard from '@/parts/app/items/WorkspaceCard.vue'
import Breadcrumb from '@/parts/app/Breadcrumb.vue'

const workspace = reactive(new Workspace())
const form = useForm<Workspace>(workspace)
const logo = ref<any>(null)

function store() {
  form.transform(() => workspace.data)
  form.post(route('app.workspace.store'))
}
</script>

<template>
  <Head :title="$t('models.workspace.add')" />

  <BaseLayout>
    <Breadcrumb :title="$t('models.workspace.add')" />

    <VRow>
      <VCol
        cols="12"
        lg="7"
      >
        <WorkspaceForm
          key="workspaceFormCreate"
          v-model:logo="logo"
          :workspace
          :form
          @submit="store"
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
