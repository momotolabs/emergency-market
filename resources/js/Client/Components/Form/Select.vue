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
    required: true,
  },
  options: {
    type: Array,
    required: false,
  },
  itemValue: {
    type: String,
    required: false,
    default: "id",
  },
  itemText: {
    type: String,
    required: false,
    default: "name",
  },
});

const emit = defineEmits(["update:modelValue", "changed"]);
const value = computed({
  get() {
    return props.modelValue ?? '';
  },
  set(value) {
    emit("update:modelValue", value);
    emit('changed', value)
  },
});

</script>

<template>
  <Label :label="props.label" :required="props.required">
    <select
      v-model="value"
      class="mt-1 px-4 block w-full rounded-md border border-none bg-input-background py-4 text-[16px] shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
      :disabled="props.disabled"
      :required="props.required"
    >
    <option value="" class="text-placeholder" selected>{{props.placeholder}}</option>
      <slot>
        <option
          v-for="(item, index) in props.options"
          :value="item[props.itemValue]"
        >
          {{ props.itemText.split('.').reduce((acc, part) => acc && acc[part], item) }}
          <!-- {{ item[props.itemText] }} -->
        </option>
      </slot>
    </select>
    <ErrorValidation v-if="props.errorMessage" :message="props.errorMessage" />
  </Label>
</template>
