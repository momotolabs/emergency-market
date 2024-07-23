<script setup>
const props = defineProps({
  legend: {
    type: String,
    required: true
  }
})
</script>

<template>
  <fieldset class="border-t-[1px] border-solid border-[#c8c7c7] w-auto min-w-0">
    <legend class="w-auto text-[#c9c7c7] py-5 font-bold">
      {{ props.legend }}
    </legend>

    <slot />
  </fieldset>
</template>
