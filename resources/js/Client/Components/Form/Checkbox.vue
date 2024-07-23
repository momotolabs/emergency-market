<script setup>
import { Label, ErrorValidation } from "@/Client/Components/Form";
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
  <Label :label="props.label" :required="props.required" checkbox>
    <template #label>
      <slot name="label" />
    </template>
    <input type="checkbox" v-model="value" class="h-5 w-5 rounded"/>
    <ErrorValidation
      v-if="props.errorMessage !== false"
      :message="props.errorMessage"
      :name="props.name"
    />
  </Label>
</template>
