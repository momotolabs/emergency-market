<script setup>
import { ref } from "vue";

const props = defineProps({
  message: {
    type: Array,
    required: true,
  },
  name: {
    type: String,
  },
});

const property = ref();

const getProperty = (error) => {
  if (props.name) {
    return props.name;
  } else {
    return error.$message.includes("Value") || error.$message.includes(error.$property)
        ? error.$property
        : "";
  }
}
</script>

<template>
  <div v-for="error in props.message" :key="error.$uid" class="text-error">
    <span v-if="getProperty(error).includes('Email')" v-html="error.$message">
    </span>
    <span class="text-sm mt-1 text-error font-normal normal-case" v-else v-html="
      `${getProperty(error)} ${error.$message
        .replace('Value ', '')
        .replace('The value', '')
        .replace('This field', '')
        .replace(`The ${error.$property}`, '')}`">
    </span>
  </div>
</template>
