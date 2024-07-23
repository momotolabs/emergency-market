<script setup>
defineProps({
  backgroundCard: {
    type: String,
    required: true
  }
})
</script>
<template>
  <div
    class="group h-[300px] 2xl:h-[329px] w-full bg-cover bg-center bg-no-repeat rounded-[32px] relative overflow-hidden cursor-pointer
    after:absolute after:left-0 after:top-0 after:w-full after:h-full after:bg-[#14142a80]"
  >
    <img
      :src="backgroundCard"
      alt="Service image"
      class="group-hover:scale-110 absolute left-0 top-0 object-cover w-full h-full transition-all duration-500 ease-in-out"
    >
    <div class="relative z-10 flex flex-col justify-center items-center h-full w-[70%] mx-auto text-center">
      <slot />
    </div>
  </div>
</template>