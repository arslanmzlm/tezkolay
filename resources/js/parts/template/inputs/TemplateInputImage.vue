<script setup lang="ts">
import { ref } from 'vue'
import type Question from '@/Models/Question'
import Options from '@/parts/template/TemplateInputOptions.vue'
import type { FileResult, GetImageResponse } from '@/Helpers/Upload'
import { getImage } from '@/Helpers/Upload'

defineProps<{
  showOptions: boolean
}>()

const question = defineModel<Question>({ required: true })

const mainImage = question.value.getValueImage()
const imageSrc = ref<FileResult | string | null>(mainImage)

async function fileSelected(event: Event) {
  try {
    const response: GetImageResponse | void = await getImage(event)

    if (typeof response === 'object') {
      question.value.setValue(response.file)

      imageSrc.value = response.imageData
    }
  }
  catch (err) {
    imageSrc.value = mainImage
    question.value.setValue(mainImage)
  }
}

function removeImage() {
  imageSrc.value = null
  question.value.setValue(null)
}
</script>

<template>
  <VFileInput
    accept="image/*"
    name="logo"
    :label="$t('attributes.image')"
    :prepend-icon="null"
    prepend-inner-icon="tabler-photo"
    @input="fileSelected"
    @click:clear="removeImage"
  />

  <div
    v-if="imageSrc && typeof imageSrc === 'string'"
    class="mt-5"
  >
    <img
      :src="imageSrc"
      :title="$t('labels.uploaded_image')"
      :alt="$t('labels.uploaded_image')"
      class="preview-img"
    >
  </div>

  <Options
    v-if="showOptions"
    v-model="question"
    :has-require="false"
    :has-score="false"
    :can-store="false"
  />
</template>
