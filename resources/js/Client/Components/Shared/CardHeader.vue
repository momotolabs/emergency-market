<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  subtitle: {
    type: String,
    required: false
  },
  center: {
    type: Boolean,
    required: false,
    default: false
  }
})
</script>

<template>
  <div>
    <h1
      class="font-bold text-2xl text-title-active"
      :class="{'text-center': props.center}"
    >{{props.title}}</h1>
    <p class="font-normal text-base tracking-[0.75px] text-body">
      <slot name="subtitle">
        {{props.subtitle}}
      </slot>
    </p>
  </div>
</template>
