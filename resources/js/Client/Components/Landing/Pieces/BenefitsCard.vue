<script setup>
defineProps({
  backgroundCard: {
    type: String,
    required: true
  }
})
</script>
<template>
  <div class="group min-h-[540px] h-[540px] xl:h-[750px] bg-cover bg-center bg-no-repeat relative cursor-pointer overflow-hidden font-inter" >
    <img
      :src="backgroundCard"
      alt="Card background"
      class="group-hover:scale-110 absolute left-0 top-0 object-cover w-full h-full transition-all duration-500 ease-in-out"
    >
    <div class="relative z-10 text-white mx-10 translate-y-8 md:translate-y-20 2xl:translate-y-[150px]">
      <slot />
    </div>
  </div>
</template>