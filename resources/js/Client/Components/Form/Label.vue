<script setup>
const props = defineProps({
  label: {
    type: String,
    required: false,
  },
  required: {
    type: Boolean,
    required: false,
    default: false,
  },
  checkbox: {
    type: Boolean,
    required: false,
    default: false,
  },
});
</script>

<template>
  <label
    class="flex"
    :class="{
      'flex-row-reverse items-center justify-end gap-2': props.checkbox,
      'flex-col': !props.checkbox,
    }"
  >
    <div class="pb-1 font-medium text-base leading-6 text-label">
      <slot name="label">
        {{ props.label }}
      </slot>
      <span v-if="props.required" class="text-error">*</span>
    </div>
    <slot />
  </label>
</template>
