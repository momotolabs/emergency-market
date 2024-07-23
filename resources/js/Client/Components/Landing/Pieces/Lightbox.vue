<script setup>
import { IconCancel } from '@/Client/Components/Landing/Icons'
defineProps({
  lightboxContent: {
    type: Object,
    required: true
  },
  isShowLightbox: {
    type: Boolean,
    required: true
  },
  closeLightbox: Function
})
</script>

<template>
  <section
    class="fixed bg-[#14142a40] w-full h-full left-0 top-0 flex justify-center items-center transition-transform duration-200 ease-in-out translate-x-full z-50"
    :class="{ '!translate-x-0': isShowLightbox }"
  >
    <div
      class="
        w-[90%] h-[70%] scale-0 transition-transform duration-300 delay-200 bg-background grid grid-cols-1 gap-1 place-items-center p-[10%] drop-shadow-[0_4px_50px_rgba(38,37,79,0.45)]
        md:w-[60%] md:h-[55%] lg:px-[10%] py-[3%] 2xl:p-[100px] 2xl:w-[850px] 2xl:h-[500px]
      "
      :class="{ '!scale-100': isShowLightbox }"
    >
      <IconCancel class="absolute top-[60px] right-[60px] cursor-pointer" @click="closeLightbox" />
      <img
        :src="lightboxContent.avatar"
        :alt="`photo of ${lightboxContent.name}`"
        class="w-[100px]"
      >
      <p class="m-0 text-justify max-h-[75%] overflow-y-auto md:max-h-[80%] 2xl:max-h-[110%] custom-scroll">{{ lightboxContent.review }}</p>
      <h3 class="m-0 text-center font-bold text-2xl">{{ lightboxContent.title }}</h3>
      <p class="font-bold text-sm text-primary md:text-xl">
        {{ lightboxContent.ocupation }}
        <span class="font-normal">
          {{ lightboxContent.location }}
        </span>
      </p>
    </div>
  </section>
</template>