<script setup>
import { Carrousel } from '@/Client/Components/Landing/Slide/index.js'
import { ServiceSlideItems } from '@/Client/Components/Landing/Utils/ServiceSlideItem.js'
</script>

<template>
  <section id="our-purpose" class="slider-container">
    <Carrousel :slides="ServiceSlideItems" :has-control="true" />
  </section>
</template>

<style scoped>
.slider-container {
  width: 100%;
  height: 580px;
  position: relative;
  overflow: hidden;
}

.slider-container::after {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.4);
}

@media (min-width: 1280px) {
  .slider-container {
    height: calc(100vh - 80px);
  }
}
</style>
