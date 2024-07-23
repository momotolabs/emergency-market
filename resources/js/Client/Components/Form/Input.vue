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
  name: {
    type: String,
    required: false,
  },
  textarea: {
    type: Boolean,
    required: false,
    defautl: false,
  },
  hasUrl: {
    type: Boolean,
    required: false,
    default: false
  }
});

if (props.hasUrl) props.modelValue+"serser"

const emit = defineEmits(["update:modelValue"]);
const value = computed({
  get() {
    if (props.hasUrl) {
      return props.modelValue?.replace('https://', '')
    } else {
      return props.modelValue;
    }
  },
  set(value) {
    if (props.hasUrl) {
      emit("update:modelValue", 'https://' + value?.replace('https://', ''));
    } else {
      emit("update:modelValue", value);
    }
  },
});
</script>

<template>
  <Label :label="props.label" :required="props.required">
    <div v-if="!props.textarea" class="relative flex flex-row w-full">
      <span v-if="props.hasUrl" class="absolute left-1 p-[18px]">https://</span>
      <input
        class="bg-input-background w-full border-none p-[18px] text-[16px] rounded-lg active:outline-none hover:outline-none focus:outline-none disabled:bg-input-background placeholder:text-placeholder placeholder:font-medium"
        :type="props.type"
        v-model="value"
        :placeholder="props.placeholder"
        :required="props.required"
        :autocomplete="props.autocomplete"
        :disabled="disabled"
        :class="{'!pl-[5.4rem]' : props.hasUrl}"
        v-bind="$attrs"
      />
    </div>
    <textarea
      class="bg-input-background border-none p-[18px] text-[16px] rounded-lg active:outline-none hover:outline-none focus:outline-none disabled:bg-gray-300 placeholder:text-placeholder placeholder:font-medium"
      :type="props.type"
      v-model="value"
      :placeholder="props.placeholder"
      :required="props.required"
      :autocomplete="props.autocomplete"
      :disabled="disabled"
      cols="30"
      rows="4"
      v-else
    ></textarea>
    <ErrorValidation
      v-if="props.errorMessage !== false"
      :message="props.errorMessage"
      :name="props.name"
    />
  </Label>
</template>
