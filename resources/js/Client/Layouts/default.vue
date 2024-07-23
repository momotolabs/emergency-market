<script setup>
import LandingHeader from '@/Client/Components/Landing/LandingHeader.vue'
import { Notification } from '@/Client/Components/Shared';
</script>

<template>
  <div>
    <LandingHeader />
    <main class="p-4 md:p-16 mt-[100px]">
      <slot />
    </main>
    <Notification />
  </div>
</template>
