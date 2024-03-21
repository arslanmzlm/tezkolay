<script setup lang="ts">
import { reactive, ref } from 'vue'
import type { InertiaForm } from '@inertiajs/vue3'
import Draggable from 'vuedraggable'
import type Template from '@/Models/Template'
import type Type from '@/Models/Type'
import TemplateInput from '@/parts/template/TemplateInput.vue'

defineProps<{
  types: Array<Type>
  form: InertiaForm<Template>
}>()

const emits = defineEmits(['submit'])

const template = defineModel<Template>({ required: true })

const popoverStates = reactive<Record<number, boolean>>({})
const addMultipleQuestionCount = ref(1)

function addMultipleQuestion(type: Type) {
  const valid = template.value.questions.addMultiple(addMultipleQuestionCount.value, type)

  if (valid) {
    addMultipleQuestionCount.value = 1
    if (type.id)
      popoverStates[type.id] = false
  }
}
</script>

<template>
  <form @submit.prevent="emits('submit')">
    <VRow>
      <VCol
        cols="12"
        lg="3"
        xl="2"
      >
        <VRow>
          <VCol cols="12">
            <VCard>
              <VCardText>
                <VRow>
                  <VCol cols="12">
                    <VTextField
                      v-model="template.name"
                      :label="$t('attributes.template_name')"
                      :error-messages="form.errors.name"
                    />
                  </VCol>

                  <VCol cols="12">
                    <VTextarea
                      v-model="template.description"
                      :label="$t('attributes.template_description')"
                      :error-messages="form.errors.description"
                    />
                  </VCol>

                  <VCol cols="12">
                    <VCheckbox
                      v-model="template.is_private"
                      :label="$t('attributes.is_private')"
                      persistent-hint
                      :hint="$t('descriptions.template_is_private')"
                    />
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
          </VCol>

          <VCol cols="12">
            <VCard>
              <VCardText>
                <div
                  v-for="(type, index) in types"
                  :key="type.id ?? index"
                  class="d-flex justify-space-between mb-4 rounded border"
                >
                  <button
                    type="button"
                    class="d-flex flex-column flex-grow-1 pa-3"
                    @click="template.questions.add(type)"
                  >
                    <span class="font-weight-medium text-black">{{ type.label }}</span>
                    <span
                      v-if="type.description"
                      class="text-start"
                    ><small>{{
                      type.description
                    }}</small></span>
                  </button>

                  <VMenu
                    v-if="type.id"
                    v-model="popoverStates[type.id]"
                    :close-on-content-click="false"
                    location="end"
                  >
                    <template #activator="{ props }">
                      <button
                        type="button"
                        class="pa-3"
                        v-bind="props"
                        :title="$t('labels.add_multiple_questions')"
                      >
                        <VIcon>tabler-square-plus</VIcon>
                      </button>
                    </template>

                    <VCard min-width="300">
                      <VCardTitle>
                        {{ $t('labels.add_multiple_questions') }}
                      </VCardTitle>

                      <VCardText>
                        <VTextField
                          v-model.number="addMultipleQuestionCount"
                          type="number"
                          :label="$t('attributes.question_count')"
                          min="1"
                          max="50"
                        />
                      </VCardText>

                      <VCardActions class="justify-end">
                        <VBtn
                          variant="flat"
                          color="error"
                          size="small"
                          @click="popoverStates[type.id] = false"
                        >
                          {{ $t('labels.close') }}
                        </VBtn>

                        <VBtn
                          variant="flat"
                          color="primary"
                          size="small"
                          @click="addMultipleQuestion(type)"
                        >
                          {{ $t('labels.add') }}
                        </VBtn>
                      </VCardActions>
                    </VCard>
                  </VMenu>
                </div>
              </VCardText>
            </VCard>
          </VCol>

          <VCol cols="12">
            <VCard>
              <VCardText>
                <VBtn
                  type="submit"
                  :disabled="form.processing"
                >
                  {{ $t("labels.submit") }}
                </VBtn>
              </VCardText>
            </VCard>
          </VCol>
        </VRow>
      </VCol>

      <VCol
        cols="12"
        lg="9"
        xl="10"
      >
        <VCard>
          <VCardText>
            <Draggable
              :list="template.questions.items"
              group="questions"
              item-key="order"
              handle=".handle"
              ghost-class="ghost"
              :animation="200"
              force-fallback
              @change="template.questions.reOrder()"
            >
              <template #item="{ element, index }">
                <TemplateInput
                  v-if="element.isRenderAble"
                  v-model="template.questions.items[index]"
                  :index="index"
                />
              </template>
            </Draggable>
          </VCardText>
        </VCard>
      </VCol>
    </VRow>
  </form>
</template>
