<script setup lang="ts">
import { reactive } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import BaseLayout from '@/layouts/BaseLayout.vue'
import Template from '@/Models/Template'
import Type from '@/Models/Type'
import TemplateForm from '@/parts/template/TemplateForm.vue'

const props = defineProps<{
  types: Array<object>
}>()

const types = props.types.map(item => {
  return new Type(item)
})

const template = reactive(new Template())

provide('template', template)

const form = useForm<Template>(template)

function submit() {
  form.transform(() => template.getData())
  form.post(route('app.template.store'))
}
</script>

<template>
  <Head :title="$t('models.template.add')" />

  <BaseLayout>
    <TemplateForm
      key="templateFormCreate"
      v-model="template"
      :types
      :form
      @submit="submit"
    />
  </BaseLayout>
</template>
