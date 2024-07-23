<script setup>
defineProps({
  fillWhite: {
    type: Boolean,
    requiered: false,
    default: false
  }
})
</script>

<template>
  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M2.4541 14.9453L15.2341 2.16528"
      :class="[fillWhite ? 'stroke-white' : 'stroke-black']"
      stroke-width="4"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
    <path d="M2.51855 2.22949L15.2986 15.0095"
      :class="[fillWhite ? 'stroke-white' : 'stroke-black']"
      stroke-width="4"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
</template>