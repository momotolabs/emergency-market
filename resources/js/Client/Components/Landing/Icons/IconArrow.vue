<script setup>

const props = defineProps({
  iconWidth: {
    type: Number,
    required: false,
    default: 7
  },

  iconHeight: {
    type: Number,
    required: false,
    default: 14
  },

  isResizable: {
    type: Boolean,
    required: false,
    default: false
  }
})

</script>

<template>
  <svg :width="iconWidth" :height="iconHeight" viewBox="0 0 17 32" :class="{ 'rezise-icon' : props.isResizable }" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M1 1L16 16L1 31" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>
</template>

<style lang="css" scoped>
@media (min-width: 1280px) {
  .rezise-icon {
    width: 15px;
    height: 30px;
  }
}
</style>