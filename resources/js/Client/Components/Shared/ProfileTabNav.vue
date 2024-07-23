<script setup>
import { ref } from 'vue'
const tabHeaders = ref([
  { title: 'Profile', url: '/dashboard/profile' },
  { title: 'Resources', url: '/dashboard/profile/resources' },
  { title: 'Multimedia', url: '/dashboard/profile/multimedia' },
])

</script>
<template>
  <nav>
    <ul class="flex justify-center items-center gap-x-10 md:gap-x-16 border-b border-[#c0c0c0] pb-4 mb-4">
      <li v-for="tab in tabHeaders" :key="tab.id">
        <Link :href="tab.url" class="hover:text-primary"
          :class="{ 'text-primary font-semibold': $page.url === tab.url }"
        >
          {{ tab.title }}
        </Link>
      </li>
    </ul>
  </nav>
</template>