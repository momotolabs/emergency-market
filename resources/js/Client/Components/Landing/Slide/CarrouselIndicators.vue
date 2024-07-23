<script setup>
  defineProps({
    totalItem: {
      type: Number,
      required: true
    },
    currentIndex: {
      type: Number,
      required: true
    }
  })

  const emit = defineEmits(["switchItemm"]);
</script>

<template>
  <div class="carousel-indicators">
    <button class="carousel-indicator-item" 
      :class="{ active : currentIndex === index}" 
      v-for="(item, index) in totalItem" :key="index"
      @click="emit('switchItemm', index)"
    >
    </button>
  </div>
</template>

<style scoped>
  .carousel-indicators {
    position: absolute;
    transform: translateX(-50%);
    left: 50%;
    bottom: 20%;
    z-index: 30;
  }

  .carousel-indicator-item {
    width: 13px;
    height: 13px;
    border: none;
    background-color: #0F4BAD;
    margin: 0 12px;
    border-radius: 50%;
    cursor: pointer;
  }
  .active {
    background-color: #fff;
  }
</style>