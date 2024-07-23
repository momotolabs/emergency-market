<script setup>
import { ref, onMounted, onBeforeMount } from 'vue'
import { CarrouselItem, CarrouselControl, CarrouselIndicators } from '@/Client/Components/Landing/Slide/index.js'
const props = defineProps({
  slides: {
    type: Object
  },
  slideContent: {
    type: Object,
    required: false
  },
  hasControl: {
    type: Boolean,
    required: false,
    default: false
  }
})

const currentSlide = ref(0)

const slideItervall = ref(null)
const direction = ref('right')

const setCurrentSlide = (index) => {
  currentSlide.value = index
}

const startSlideTimer = () => {
  stopSlideTimer()
  slideItervall.value = setInterval(() => {
    _next()
  }, 6500)
}

const stopSlideTimer = () => {
  clearInterval(slideItervall.value)
}

onMounted(() => {
  startSlideTimer()
})

onBeforeMount(() => {
  stopSlideTimer()
})

const prev = (step = -1) => {
  const index = currentSlide.value > 0 ? currentSlide.value + step : props.slides.length - 1
  direction.value = 'left'
  setCurrentSlide(index)
  startSlideTimer()
}

const _next = (step = 1) => {
  const index = currentSlide.value < props.slides.length - 1 ? currentSlide.value + step : 0
  direction.value = 'right'
  setCurrentSlide(index)
}

const next = (step = 1) => {
  _next(step)
  startSlideTimer()
}

const switchItemm = (index) => {
  const step = index - currentSlide.value
  if (step > 0) {
    next(step)
  } else {
    prev(step)
  }
}
</script>

<template>
  <div class="carousel">
    <div class="carousel-inner">
      <CarrouselItem v-for="(slide, index) in slides" :slide="slide" :key="`item-${index}`" :currentSlide="currentSlide"
        :direction="direction" :index="index">
      </CarrouselItem>

      <CarrouselControl @prev="prev" @next="next" v-if="props.hasControl" />

      <CarrouselIndicators @switchItemm="switchItemm($event)" :totalItem="slides.length" :currentIndex="currentSlide"
        v-if="props.hasControl" />

    </div>
  </div>
</template>

<style scoped>
.carousel {
  display: flex;
  justify-content: center;
  width: 100%;
  height: 100%;
}

.carousel-inner {
  position: relative;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.carousel-content {
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  left: 0;
  top: 0;
  height: 100%;
  width: 100%;
}

.carousel-content h2 {
  text-align: center;
  color: white;
}
</style>
