<script setup>
const props = defineProps(["links", "from", "to", "total"]);
</script>

<template>
  <nav
    class="flex justify-between items-center pt-4"
    aria-label="Table navigation"
  >
    <span class="text-sm font-normal text-gray-500"
      >Showing
      <span class="font-semibold text-gray-900">
        {{ props.from }}-{{ props.to }}
      </span>
      of
      <span class="font-semibold text-gray-900">{{ props.total }}</span>
    </span>
    <div class="flex justify-center space-x-1">
      <Component
        v-for="(link, index) in props.links"
        :key="index"
        :is="link.url ? 'Link' : 'span'"
        :href="link.url"
        v-html="link.label"
        class="px-3 py-1 bg-gray-100 hover:text-white hover:bg-primary rounded"
        :class="{'cursor-not-allowed': !link.url, 'bg-primary text-white': link.active}"
        :disabled="!link.url"
        />
    </div>
  </nav>
</template>
