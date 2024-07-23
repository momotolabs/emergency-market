<script setup>
import { IconCancel } from '@/Client/Components/Landing/Icons'
import { required } from '@vuelidate/validators';
defineProps({
  isModalVisible: {
    type: Boolean,
    required: true
  },
  titleModal: {
    type: String,
    required: true
  },
  modalWidth: {
    type: String,
    required: false,
    default: 'w-[90%] md:w-[50%] 2xl:w-[450px]'
  },
  closeModal: Function
})
</script>

<template>
  <section
    class="fixed bg-[#14142a40] w-full h-full left-0 top-0 justify-center items-center z-50 font-inter"
    :class="{'hidden' : !isModalVisible, 'flex' : isModalVisible }"
  >
    <div
      class="
        h-max scale-0 bg-background drop-shadow-[0_4px_50px_rgba(38,37,79,0.45)] max-h-[calc(100vh_-_10%)] overflow-y-auto custom-scroll
      "
      :class="[{ '!scale-100': isModalVisible }, modalWidth]"
    >
      <button
        @click="closeModal"
        class="absolute top-[20px] right-[20px] cursor-pointer rounded-full"
      >
        <IconCancel />
      </button>

      <h1 class="text-xl font-medium border-b border-gray-300 px-5 pt-5 pb-2">{{ titleModal }}</h1>
      <slot />
    </div>
  </section>
</template>