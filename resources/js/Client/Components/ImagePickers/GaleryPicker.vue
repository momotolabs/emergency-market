<script setup>
import { ref } from 'vue'
import { DragZoneIcon, ClipIcon, DeleteFileIcon } from '@/Client/Components/Icons'

const props = defineProps({
  modelValue: [String, Object],
  files: {
    type: Array,
    required: true
  }
})

const emit = defineEmits(['update:modelValue'])

const inputFiles = ref([])
const active = ref(false)

const onFilesChanges = () => {
  addItemToFiles(inputFiles.value.files)
  emit('update:modelValue', props.files)
}

const onClickZone = () => {
  inputFiles.value.click()
}

const onActiveDrag = (e) => {
  active.value = !active.value

  if (e.dataTransfer.files.length > 0) {
    addItemToFiles(e.dataTransfer.files)
    emit('update:modelValue', props.files)
  }
}

const addItemToFiles = (filesToAdd) => {
  Object.values(filesToAdd).forEach(file => {
    props.files.push(file)
  })
}
</script>
<template>
  <div>
    <input
      type="file"
      name="galery-image"
      accept="image/png, image/jpeg"
      multiple
      @change="onFilesChanges"
      ref="inputFiles"
      class="hidden"
    >
    <!-- drag zone -->
    <div
      @click="onClickZone"
      @dragenter.prevent="onActiveDrag"
      @dragleave.prevent="onActiveDrag"
      @dragover.prevent
      @drop.prevent="onActiveDrag"
      class="drag-zone"
      :class="{ 'active-dropzone' : active }"
    >

      <span role="img" class="text-[48px] text-[#40a9ff]">
        <DragZoneIcon />
      </span>

      <p class="mb-0 text-[#000000d9]">
        Click or drag file to this area to upload
      </p>
      <p class="mb-0 text-[#00000073]">
        Support for a single or bulk upload. Strictly prohibit from uploading company data or other brand files
      </p>
    </div>
    <!-- end drag zone -->

    <!-- files list -->
    <div
      v-for="(image, index) in props.files"
      :key="index"
      class="group flex flex-row items-center hover:bg-[#F5F5F5] mt-2"
    >
      <span class="text-[#00000073] w-max">
        <ClipIcon />
      </span>
      <p class="grow mb-0 text-[#000000d9] px-2">{{ image.name }}</p>
      <button
        type="button"
        class="p-1 hover:bg-[rgba(0,0,0,.018)] text-[#00000073] w-6 opacity-0 group-hover:opacity-100 pr-1"
        @click="$emit('deleteFileItem', index)"
      >
        <DeleteFileIcon />
      </button>
    </div>

  </div>
</template>

<style lang="css" scoped>
.drag-zone {
  @apply bg-[#fafafa] w-full h-full cursor-pointer text-center py-4
      border border-dashed border-[#D9D9D9] hover:border-[#1890ff]
      transition-[border-color] duration-300;
}
.active-dropzone {
  @apply border-[#1890ff];
}
</style>
