<script setup>
defineProps(['titleContainer'])
</script>
<template>
  <div class="space-y-5">
    <strong class="text-base font-inter">{{ titleContainer }}</strong>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 space-y-7 md:space-y-0">
      <slot name="left" />

      <slot name="right"/>
    </div>
  </div>
</template>