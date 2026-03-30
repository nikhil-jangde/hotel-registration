<template>
  <VDropdown
    v-bind="$attrs"
    :distance="12"
    :skidding="0"
    :arrow-padding="8"
  >
    <slot />
    <template #popper>
      <slot name="content" />
    </template>
  </VDropdown>
</template>

<script setup>
// FloatingVue is already registered globally, but we wrap it for Shadcn-like API
</script>
