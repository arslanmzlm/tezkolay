<script setup lang="ts">
import type Workspace from '@/Models/Workspace'

defineProps<{
  workspace: Workspace
  logo: any
}>()
</script>

<template>
  <VCard>
    <VCardItem>
      <VAvatar
        :size="64"
        color="secondary"
        variant="tonal"
      >
        <img
          v-if="logo"
          key="isWorkspaceHasLogo"
          :src="logo"
          :alt="$t('labels.uploaded_image')"
        >
        <VIcon
          v-else
          size="36"
        >
          tabler-color-swatch
        </VIcon>
      </VAvatar>

      <p class="mt-3 text-lg font-weight-medium">
        {{ workspace.name ? workspace.name : $t("placeholders.workspace_name") }}
      </p>

      <div class="v-avatar-group">
        <VAvatar
          v-for="(group, index) in workspace.groups"
          :key="index"
          color="primary"
        >
          {{ group.nameLetters }}
        </VAvatar>
      </div>
    </VCardItem>
  </VCard>
</template>
