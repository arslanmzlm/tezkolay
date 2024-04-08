<script lang="ts" setup>
interface Props {
  menuList?: unknown[]
  itemProps?: boolean
}

const props = defineProps<Props>()
</script>

<template>
  <IconBtn
    density="compact"
    color="disabled"
  >
    <VIcon icon="tabler-dots-vertical" />

    <VMenu activator="parent">
      <VList
        v-if="props.menuList"
        :items="props.menuList"
        :item-props="props.itemProps"
      />
      <VList v-else>
        <slot />
      </VList>
    </VMenu>
  </IconBtn>
</template>
