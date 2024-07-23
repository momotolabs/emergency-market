<script setup>
import { IconCancel } from '@/Client/Components/Landing/Icons'
defineProps({
  image: {
    type: Object,
    required: true
  },
  isShowGalery: {
    type: Boolean,
    required: true
  },
  closeImageLightbox: Function
})
</script>

<template>
  <section
    class="fixed bg-[#14142a40] w-full h-full left-0 top-0 flex justify-center items-center transition-transform duration-200 ease-in-out translate-x-full z-50"
    :class="{ '!translate-x-0': isShowGalery }"
  >
    <div
      class="
        w-[90%] h-[30%] scale-0 transition-transform duration-300 delay-200 bg-background drop-shadow-[0_4px_50px_rgba(38,37,79,0.45)]
        md:w-[60%] 2xl:w-[850px] 2xl:h-[500px]
      "
      :class="{ '!scale-100': isShowGalery }"
    >
      <button
        @click="closeImageLightbox"
        class="absolute top-[60px] right-[60px] cursor-pointer rounded-full border border-white p-2 bg-gray-400"
      >
        <IconCancel :fillWhite="true" />
      </button>
      <img
        :src="image"
        :alt="`photo of ${image}`"
        class="w-full h-full object-fill"
      >
    </div>
  </section>
</template>