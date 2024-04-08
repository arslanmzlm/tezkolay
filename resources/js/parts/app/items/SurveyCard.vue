<script setup lang="ts">
import { useTheme } from 'vuetify'
import { reactive } from 'vue'
import { Link } from '@inertiajs/vue3'
import type Group from '@/Models/Group'
import type Survey from '@/Models/Survey'
import { hexToRgb } from '@layouts/utils'
import { getI18n } from '@/plugins/i18n'

const componentProps = defineProps<{
  group: Group
  survey: Survey
}>()

const vuetifyTheme = useTheme()

const { t } = getI18n().global

const patientId = ref<number | null>(null)
const popoverStates = reactive<Record<number, boolean>>({})

const series = [componentProps?.survey?.completed_percent ?? 0]

const chartOptions = computed(() => {
  const currentTheme = vuetifyTheme.current.value.colors
  const variableTheme = vuetifyTheme.current.value.variables

  return {
    labels: [t('labels.completion_rate')],
    chart: {
      type: 'radialBar',
    },
    plotOptions: {
      radialBar: {
        offsetY: 10,
        startAngle: -140,
        endAngle: 130,
        hollow: {
          size: '65%',
        },
        track: {
          background: currentTheme.surface,
          strokeWidth: '100%',
        },
        dataLabels: {
          name: {
            offsetY: -20,
            color: `rgba(${hexToRgb(currentTheme['on-background'])},${variableTheme['disabled-opacity']})`,
            fontSize: '13px',
            fontWeight: '400',
            fontFamily: 'Public Sans',
          },
          value: {
            offsetY: 10,
            color: `rgba(${hexToRgb(currentTheme['on-background'])},${variableTheme['high-emphasis-opacity']})`,
            fontSize: '38px',
            fontWeight: '400',
            fontFamily: 'Public Sans',
          },
        },
      },
    },
    colors: [currentTheme.primary],
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        shadeIntensity: 0.5,
        gradientToColors: [currentTheme.primary],
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 0.6,
        stops: [30, 70, 100],
      },
    },
    stroke: {
      dashArray: 10,
    },
    grid: {
      padding: {
        top: -20,
        bottom: 5,
      },
    },
    states: {
      hover: {
        filter: {
          type: 'none',
        },
      },
      active: {
        filter: {
          type: 'none',
        },
      },
    },
    responsive: [
      {
        breakpoint: 960,
        options: {
          chart: {
            height: 340,
          },
        },
      },
    ],
  }
})
</script>

<template>
  <VCard
    v-if="survey"
    :title="survey.name ?? ''"
    :subtitle="survey.surveyDateFormatted"
  >
    <template #append>
      <div class="d-flex gap-2 align-center justify-space-between">
        <VAlert
          :color="survey.stateColor"
          density="compact"
        >
          <div>{{ survey.stateLabel }}</div>

          <VTooltip
            activator="parent"
            location="bottom"
          >
            {{ $t("labels.survey_state") }}
          </VTooltip>
        </VAlert>

        <MoreBtn>
          <VMenu
            v-if="survey.id"
            v-model="popoverStates[survey.id]"
            :close-on-content-click="false"
            location="end"
          >
            <template #activator="{ props }">
              <VListItem
                type="button"
                class="pa-3"
                v-bind="props"
                :title="$t('labels.manuel_fill_survey')"
              />
            </template>

            <VCard width="450">
              <VCardText>
                <div
                  v-if="survey.isStartAble"
                  class="text-center font-weight-medium"
                >
                  {{ $t('descriptions.start_survey') }}
                </div>
                <div v-else>
                  <VAutocomplete
                    v-model="patientId"
                    :items="group.patients"
                    item-title="label"
                    item-value="id"
                    :placeholder="$t('select.patient')"
                  />
                </div>
              </VCardText>
              <VCardActions class="justify-center gap-2 pa-6 pt-0">
                <VBtn
                  variant="flat"
                  color="error"
                  @click="popoverStates[survey.id] = false"
                >
                  {{ $t('labels.close') }}
                </VBtn>

                <Link
                  v-if="survey.isStartAble"
                  :href="route('app.survey.initialize', { survey })"
                  method="post"
                  as="div"
                >
                  <VBtn
                    variant="flat"
                    color="success"
                  >
                    {{ $t('labels.start') }}
                  </VBtn>
                </Link>
                <Link
                  v-else-if="patientId"
                  :href="route('app.survey.item.show', { survey, patient: patientId })"
                >
                  <VBtn
                    variant="flat"
                    color="primary"
                  >
                    {{ $t('labels.fill') }}
                  </VBtn>
                </Link>
              </VCardActions>
            </VCard>
          </VMenu>
        </MoreBtn>
      </div>
    </template>

    <VCardText>
      <VRow>
        <VCol
          cols="12"
          md="5"
          sm="6"
          class="mt-auto"
        >
          <!-- <div class="mb-6"> -->
          <!--  <h4 class="text-h1"> -->
          <!--    {{ group.name }} -->
          <!--  </h4> -->
          <!--  <p> -->
          <!--    Total Tickets -->
          <!--  </p> -->
          <!-- </div> -->

          <VList class="card-list">
            <VListItem>
              <VListItemTitle class="font-weight-medium">
                {{ $t('titles.group') }}
              </VListItemTitle>
              <VListItemSubtitle class="text-disabled">
                {{ group.name }}
              </VListItemSubtitle>
              <template #prepend>
                <VAvatar
                  rounded
                  size="38"
                  color="primary"
                  variant="tonal"
                >
                  <VIcon icon="tabler-users-group" />
                </VAvatar>
              </template>
            </VListItem>

            <VListItem>
              <VListItemTitle class="font-weight-medium">
                {{ $t('labels.group_size') }}
              </VListItemTitle>
              <VListItemSubtitle class="text-disabled">
                {{ group.size }}
              </VListItemSubtitle>
              <template #prepend>
                <VAvatar
                  rounded
                  size="38"
                  color="info"
                  variant="tonal"
                >
                  <VIcon icon="tabler-users" />
                </VAvatar>
              </template>
            </VListItem>

            <VListItem>
              <VListItemTitle class="font-weight-medium">
                {{ $t("labels.survey_item_completed") }}
              </VListItemTitle>
              <VListItemSubtitle class="text-disabled">
                {{ survey.completed_count }}
              </VListItemSubtitle>
              <template #prepend>
                <VAvatar
                  rounded
                  size="38"
                  color="success"
                  variant="tonal"
                >
                  <VIcon icon="tabler-clipboard-check" />
                </VAvatar>
              </template>
            </VListItem>

            <!-- <VListItem> -->
            <!--  <VListItemTitle class="font-weight-medium"> -->
            <!--    {{ $t("labels.survey_item_pending") }} -->
            <!--  </VListItemTitle> -->
            <!--  <VListItemSubtitle class="text-disabled"> -->
            <!--    0 -->
            <!--  </VListItemSubtitle> -->
            <!--  <template #prepend> -->
            <!--    <VAvatar -->
            <!--      rounded -->
            <!--      size="38" -->
            <!--      color="warning" -->
            <!--      variant="tonal" -->
            <!--    > -->
            <!--      <VIcon icon="tabler-clipboard"/> -->
            <!--    </VAvatar> -->
            <!--  </template> -->
            <!-- </VListItem> -->
          </VList>
        </VCol>

        <VCol
          cols="12"
          md="7"
          sm="6"
        >
          <VueApexCharts
            :options="chartOptions"
            :series="series"
            height="340"
          />
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>
