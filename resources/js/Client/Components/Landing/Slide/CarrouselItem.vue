<script setup>
  import { computed } from 'vue'
  import { LandingButton } from '@/Client/Components/Landing/Pieces/index.js'
  import { usePage } from '@inertiajs/inertia-vue3'

  const props = defineProps({
    slide: {
      type: Object,
      required: true
    },

    currentSlide: {
      type: Number,
      required: true,
    },

    index: {
      type: Number,
      required: true
    },

    direction: {
      type: String
    }
  })

  const transitionEffect = computed(() => {
    return props.direction === 'right' ? 'slide-out' : 'slide-in'
  })

  const user = computed(() => usePage().props.value.auth?.user)
</script>

<template>
  <transition :name="transitionEffect">
    <div class="carousel-item" v-show="props.currentSlide === props.index">
      <img :src="props.slide.background" alt="">
      <div class="carousel-content">
        <h2 class="section-title section-title__white">{{ props.slide.title }}</h2>
        <div class="slide-description" v-html="props.slide.description"></div>
        <div v-if="props.slide.hasButton">
          <LandingButton
            :buttonText=" user ? 'Dashboard' : 'Sign Up' "
            :navigation=" user ? 'dashboard.contracts.open' : 'join.index' "
            typeButton="white"
          />
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped>
  .carousel-item {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }

  .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .slide-in-enter-active,
  .slide-in-leave-active,
  .slide-out-enter-active,
  .slide-out-leave-active {
    transition: all 1.6s ease-in-out;
  }

  .slide-in-enter-from {
    transform: translateX(-100%);
  }
  .slide-in-leave-to {
    transform: translateX(100%);
  }
  .slide-out-enter-from {
    transform: translateX(100%);
  }
  .slide-out-leave-to {
    transform: translateX(-100%);
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
    z-index: 30;
    padding: 0 15%;
  }

  .carousel-content .slide-description {
    font-weight: 400;
    font-size: 17px;
    line-height: 30px;
    color: #fff;
    text-align: justify;
    margin-bottom: 2.5rem;
  }

  @media (max-width: 768px) {
    .carousel-content .slide-description {
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 10;
      line-clamp: 10;
      -webkit-box-orient: vertical;
    }
  }

  @media (min-width: 768px) {
    .carousel-content .slide-description {
      font-size: 22px;
      text-align: center;
    }
  }

  @media (min-width: 1024) {
    .carousel-content {
      padding: 0 35%;
    }
  }
</style>
