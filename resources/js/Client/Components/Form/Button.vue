<script setup>
const emit = defineEmits(['click'])
const props = defineProps({
  loading: {
    type: Boolean,
    required: false,
    default: false,
  },
  type: {
    type: String,
    required: false,
    default: 'submit'
  },
  secundary: {
    type: Boolean,
    required: false,
    default: false,
  },
  disabled: {
    type: Boolean,
    required: false,
    default: false,
  }
});

</script>

<template>
  <button
    class="cursor-pointer p-[10px] outline-none w-full rounded-lg font-bold text-base justify-center"
    :type="props.type"
    :class="{
      'bg-primary text-white border-0': !props.secundary,
      'bg-white text-primary border-2 border-primary': props.secundary,
      'bg-line text-placeholder cursor-not-allowed': props.disabled || props.loading
    }"
    @click="$emit('click')"
    :disabled="props.disabled || props.loading"
  >
    <div class="items-center justify-center mt-0 flex">
      <svg
        class="bg-none block mr-[5px]"
        v-if="props.loading"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        style="shape-rendering: auto"
        width="20px"
        height="20px"
        viewBox="0 0 100 100"
        preserveAspectRatio="xMidYMid"
      >
        <circle
          cx="50"
          cy="50"
          fill="none"
          stroke="#fff"
          stroke-width="10"
          r="35"
          stroke-dasharray="164.93361431346415 56.97787143782138"
        >
          <animateTransform
            attributeName="transform"
            type="rotate"
            repeatCount="indefinite"
            dur="1s"
            values="0 50 50;360 50 50"
            keyTimes="0;1"
          />
        </circle>
      </svg>

      <slot />
    </div>
  </button>
</template>
