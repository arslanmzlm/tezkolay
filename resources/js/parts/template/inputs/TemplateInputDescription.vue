<script setup lang="ts">
import { ref } from 'vue'
import type Question from '@/Models/Question'
import Options from '@/parts/template/TemplateInputOptions.vue'
import type { FileResult, GetImageResponse } from '@/Helpers/Upload'
import { getImage } from '@/Helpers/Upload'
import type { IMAGE_POSITION } from '@core/enums'
import { IMAGE_POSITIONS } from '@core/enums'

defineProps<{
  showOptions: boolean
}>()

const { t } = useI18n()

const question = defineModel<Question>({ required: true })

if (question.value.options === null)
  question.value.options = {}

const mainImage = question.value.getOptionImage()
const imageSrc = ref<FileResult | string | null>(question.value.getOptionImage())

const imagePositions: Array<{
  label: string
  value: IMAGE_POSITION
}> = []

IMAGE_POSITIONS.forEach(position => {
  imagePositions.push({
    label: t(`options.image_positions.${position}`),
    value: position,
  })
})

async function fileSelected(event: Event) {
  try {
    const response: GetImageResponse | void = await getImage(event)

    if (typeof response === 'object') {
      question.value.setOption('image', response.file)

      imageSrc.value = response.imageData
    }
  }
  catch (err) {
    imageSrc.value = mainImage
    question.value.setOption('image', mainImage)
  }
}

function removeImage() {
  imageSrc.value = null
  question.value.setOption('image', null)
}
</script>

<template>
  <TiptapEditor
    :model-value="question.value ?? ''"
    class="border rounded basic-editor"
    :placeholder="$t('placeholders.output_description')"
    @update:model-value="value => question.setValue(value)"
  />

  <div
    v-if="imageSrc"
    class="mt-5"
  >
    <img
      v-if="typeof imageSrc === 'string'"
      :src="imageSrc"
      :title="$t('labels.uploaded_image')"
      :alt="$t('labels.description_image')"
      class="preview-img"
    >
  </div>

  <Options
    v-if="showOptions"
    v-model="question"
    :has-require="false"
    :has-description="false"
    :has-score="false"
    :can-store="false"
  >
    <VCol cols="12">
      <div class="option-row">
        <VFileInput
          accept="image/*"
          name="logo"
          :label="$t('attributes.image')"
          :prepend-icon="null"
          prepend-inner-icon="tabler-photo"
          @input="fileSelected"
          @click:clear="removeImage"
        />
      </div>
    </VCol>

    <VCol
      v-if="question.options"
      cols="12"
    >
      <div class="option-row">
        <VSelect
          v-model="question.options.image_position"
          :items="imagePositions"
          item-title="label"
          item-value="value"
          :label=" $t('attributes.image_position')"
        />
      </div>
    </VCol>
  </Options>
</template>
