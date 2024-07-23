<script setup>
  import { IconArrow } from '@/Client/Components/Landing/Icons/index.js'
  const emit = defineEmits(["prev", "next"]);
</script>

<template>
  <button
    @click="emit('prev')"
    class="carousel-control left"
  >
    <IconArrow :isResizable="true"/>
  </button>

  <button
    @click="emit('next')"
    class="carousel-control rigth"
  >
    <IconArrow :isResizable="true"/>
  </button>
</template>

<style scoped>
  .carousel-control {
    background-color: transparent;
    border: none;
    display: inline-block;
    position: absolute;
    height: 50px;
    width: 70px;
    top: calc(50% - 25px);
    color: #f3f3f3;
    cursor: pointer;
    z-index: 30;
  }

  .left {
    left: 10px;
    transform: rotate(180deg);
    -ms-transform-origin-y: 47%;
    -webkit-transform-origin-y: 47%;
  }
  .rigth {
    right: 10px;
  }

  @media (min-width: 1536px) {
    .left {
      left: 140px;
      -ms-transform-origin-y: 45%;
      -webkit-transform-origin-y: 45%;
    }
    .rigth {
      right: 140px;
    }
  }
</style>
