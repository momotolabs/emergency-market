<script setup>
import { Default as DefaultLayout } from "@/Client/Layouts";
import LandingFooter from '@/Client/Components/Landing/Footer.vue'
</script>
<template>
  <DefaultLayout>
    <div class="max-w-[1200px] mx-auto mt-[10%] text-justify md:pt-[4rem] px-3 md:px-[4.5rem]">
      <div class="pt-[3rem] md:px-[6rem]">
        <h1 class="m-0 font-bold text-[16px] md:text-[32px] pb-[1rem]">Terms of service</h1>

      </div>
    </div>
  </DefaultLayout>
  <LandingFooter />
</template>

<style lang="css" scoped>
* {
  font-family: 'Inter';
}
p {
  @apply text-sm text-[#000000d9] leading-[1.5715];
}
h3 {
  @apply font-bold my-4 text-base;
}
</style>
