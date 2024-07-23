<script setup>
import { Label, ErrorValidation } from ".";
import { computed } from "vue";

const props = defineProps({
  modelValue: [String, Number, Boolean, Object],
  type: {
    type: String,
    required: false,
    default: "text",
  },
  placeholder: {
    type: String,
    required: false,
  },
  disabled: {
    type: Boolean,
    required: false,
    default: false,
  },
  required: {
    type: Boolean,
    required: false,
    default: false,
  },
  autocomplete: {
    type: String,
    required: false,
    default: "off",
  },
  errorMessage: {
    type: [Boolean, String, Array],
    required: false,
    default: false,
  },
  label: {
    type: String,
    required: false,
  },
  name: {
    type: String,
    required: false
  }
});

const emit = defineEmits(["update:modelValue"]);
const value = computed({
  get() {
    return props.modelValue;
  },
  set(value) {
    emit("update:modelValue", value);
  },
});
</script>

<template>
  <Label label="" checkbox class="">
    <div class="inline-flex relative items-center cursor-pointer">
      <input type="checkbox" value="" class="sr-only peer" v-model="value" :disabled="props.disabled">
      <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
      <span class="ml-3 text-sm font-medium text-gray-900 ">{{ props.label }}</span>
    </div>
  </Label>
</template>
