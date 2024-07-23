<script setup>

</script>

<template>
  <section class="mt-3 w-auto m-auto bg-white shadow-lg border-2 p-5 md:p-12 md:w-[610px] rounded-lg">
    <slot name="header" />
    <slot />
    <slot name="footer" />
  </section>
</template>
