<script setup>
import { WarningOutlined } from "@ant-design/icons-vue";
import { ref, watch } from "vue";

const props = defineProps(['notification', 'show']);

const showN = ref(false);

watch(props, () => {
  if(props.show){
    showN.value = true
    setTimeout(() => {
      showN.value = false
    }, 5000);
  }
}, { deep: true })
</script>

<template>
  <div class="relative" v-if="showN">
    <div class="fixed top-0 left-0 right-0 flex items-center justify-center ">
      <div

        id="toast-success"
        class="flex items-center justify-center p-4 mb-4 mt-32 w-full max-w-xs text-white bg-red-500 rounded-lg shadow "
        role="alert"
      >
        <div
          class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-red-500 bg-red-100 rounded-lg"
        >
          <WarningOutlined />
          <span class="sr-only">Check icon</span>
        </div>
        <div class="ml-3 text-sm font-normal">{{ notification.message }}</div>
        <button
          type="button"
          class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 "
          data-dismiss-target="#toast-success"
          aria-label="Close"
          @click="showN = false"
        >
          <span class="sr-only">Close</span>
          <svg
            aria-hidden="true"
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>
