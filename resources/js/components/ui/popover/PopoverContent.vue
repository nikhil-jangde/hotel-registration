<template>
  <div :class="['p-4 bg-white dark:bg-gray-800 rounded-md shadow-2xl z-50', $attrs.class]">
    <slot />
  </div>
</template>

<script setup>
defineOptions({
  inheritAttrs: false
})
</script>
