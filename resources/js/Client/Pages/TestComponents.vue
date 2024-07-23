<script setup>
import { ref } from 'vue'
import { AvatarPicker, GaleryPicker } from '@/Client/Components/ImagePickers/index.js'

const profilePicture = ref('')
const galeryImages = ref([])

const saveProfile = () => {
  console.log('imagen', profilePicture.value);
}

const updateGalery = () => {
  console.log('galery', galeryImages.value);
}
</script>

<template>
  <div class="p-12">
    <h2>Page only test components</h2>
    <AvatarPicker v-model="profilePicture" />
    <p>imagen {{ profilePicture.name }}</p>
    <button class="p-1 bg-blue-600 text-white" @click="saveProfile">
      Save profile
    </button>
    <hr class="my-4">
    <div class="w-[500px]">
      <h2>Galery</h2>
      <GaleryPicker v-model="galeryImages" />
      <button class="bg-blue-600 text-white p-1 mt-3" @click="updateGalery">
        Update galery
      </button>
    </div>
  </div>
</template>