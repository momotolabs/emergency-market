<script setup>
  const props = defineProps({
    item: [Object, String, Number],
    main: {
      type: Boolean,
      default: false,
    }
  })
</script>

<template>
  <th
    scope="row"
    class="py-4 px-6"
    :class="{ 'font-medium text-gray-900 whitespace-nowrap': !props.main }"
  >
  <slot>
    {{ props.item }}
  </slot>
  </th>
</template>
