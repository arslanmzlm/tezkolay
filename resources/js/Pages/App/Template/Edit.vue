<script setup lang="ts">
import { reactive } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import BaseLayout from '@/layouts/BaseLayout.vue'
import Template from '@/Models/Template'
import Type from '@/Models/Type'
import TemplateForm from '@/parts/template/TemplateForm.vue'
import Breadcrumb from '@/parts/app/Breadcrumb.vue'

const props = defineProps<{
  types: Array<object>
  template: object
}>()

const types = props.types.map(item => {
  return new Type(item)
})

const template = reactive(new Template(props.template))

provide('template', template)

const form = useForm<Template>(template)

function submit() {
  form.transform(() => template.getData())
  form.post(route('app.template.update', template))
}
</script>

<template>
  <Head :title="$t('models.template.edit')" />

  <BaseLayout>
    <Breadcrumb :title="$t('models.template.edit')" />

    <TemplateForm
      key="templateFormEdit"
      v-model="template"
      :types
      :form
      @submit="submit"
    />
  </BaseLayout>
</template>
