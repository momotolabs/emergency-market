<script setup>
import { ref } from 'vue'
import { PlusIcon } from '@/Client/Components/Icons'

defineProps({
  modelValue: [String, Object],
})

const emit = defineEmits(['update:modelValue'])

const previewImg = ref(null)
const inputAvatar = ref()

const pickImage = () => {
  inputAvatar.value.click()
}

const onFileChange = () => {
  previewImg.value = URL.createObjectURL(inputAvatar.value.files[0])
  emit('update:modelValue', inputAvatar.value.files[0])
}
</script>

<template>
  <div class="">
    <input
      type="file"
      name="avatar"
      ref="inputAvatar"
      @change="onFileChange"
      class="hidden"
    >

    <div
      class="bg-[#fafafa] w-[100px] h-[100px] cursor-pointer
      border border-dashed border-[#D9D9D9] hover:border-[#1890ff] transition-[border-color] duration-300"
      @click="pickImage"
    >
      <div
        v-if=" !previewImg "
        class="flex flex-col items-center justify-center text-center h-full w-full"
      >
        <PlusIcon />
        <p class="mb-0">Click on this area to upload</p>
      </div>

      <div v-else>
        <img 
          :src="previewImg" alt="Preview image"
          class="object-cover w-[100px] h-[100px]"
        >
      </div>
    </div>
  </div>
</template>