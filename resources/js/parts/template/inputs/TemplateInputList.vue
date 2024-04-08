<script setup lang="ts">
import Draggable from 'vuedraggable'
import type Question from '@/Models/Question'
import Options from '@/parts/template/TemplateInputOptions.vue'
import { LIST_STYLE, LIST_STYLES } from '@core/enums'

defineProps<{
  showOptions: boolean
}>()

const question = defineModel<Question>({ required: true })

if (question.value.options === null)
  question.value.options = { list_style: LIST_STYLE.DISC }

const { t } = useI18n()

const listStyles: Array<{
  label: string
  value: LIST_STYLE
}> = []

LIST_STYLES.forEach(style => {
  listStyles.push({
    label: t(`options.list_styles.${style}`),
    value: style,
  })
})

// const listClass = computed<string>(() => {
//   return LIST_ORDERED_STYLES.includes(listStyle.value) ? 'ol' : 'ul'
// })
</script>

<template>
  <div class="flex flex-col gap-3">
    <Draggable
      v-if="question.values"
      :list="question.values"
      item-key="index"
      handle=".handle"
      ghost-class="ghost"
      :animation="200"
      :style="{ listStyleType: (question?.options?.list_style ?? LIST_STYLE.DISC) }"
    >
      <template #item="{ element, index }">
        <div class="d-flex align-center gap-4 mb-2">
          <VTextField
            v-model="element.label"
            variant="outlined"
            :label="$t('attributes.item')"
          />

          <div>
            <VBtn
              variant="tonal"
              rounded="0"
              icon="tabler-arrows-move-vertical"
              size="x-small"
              class="handle me-2"
            />

            <VBtn
              variant="tonal"
              color="error"
              rounded="0"
              icon="tabler-x"
              size="x-small"
              @click="question.removeValues(index)"
            />
          </div>
        </div>
      </template>
    </Draggable>

    <VBtn
      block
      color="primary"
      variant="tonal"
      append-icon="tabler-plus"
      @click="question.addValues()"
    >
      {{ $t("labels.add_item") }}
    </VBtn>
  </div>

  <Options
    v-if="showOptions"
    v-model="question"
    :has-require="false"
    :has-score="false"
  >
    <VCol
      v-if="question.options"
      cols="12"
    >
      <div class="option-row">
        <VSelect
          v-model="question.options.list_style"
          :items="listStyles"
          item-title="label"
          item-value="value"
          :label=" $t('attributes.list_style')"
        />
      </div>
    </VCol>
  </Options>
</template>
