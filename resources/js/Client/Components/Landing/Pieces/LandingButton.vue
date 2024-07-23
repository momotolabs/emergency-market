<script setup>
import { IconArrow } from '@/Client/Components/Landing/Icons/index.js'
// import

const props = defineProps({
  buttonText: {
    type: String,
    required: true
  },

  typeButton: {
    type: String,
    required: false,
    default: 'buttonBlue'
  },

  hasArrow: {
    type: Boolean,
    required: false,
    default: false
  },

  navigation: {
    type: String,
    required: true
  }
})

</script>

<template>
  <button class="group cursor-pointer min-w-[200px] rounded-lg py-[18px] border-[2px] text-base font-bold leading-7 bg-transparent transition-all duration-500"
    @click="$inertia.get(route(props.navigation))"
    :class="[props.typeButton === 'white' ? 'border-white hover:bg-white hover:text-primary hover:border-white' : 'border-primary text-primary hover:text-white hover:bg-primary ']">
    {{ props.buttonText }}
    <span v-if="props.hasArrow" style="margin-left: 10px; display: inline-block;">
      <IconArrow class="[&>path]:stroke-primary group-hover:[&>path]:stroke-white" />
    </span>
  </button>
</template>
