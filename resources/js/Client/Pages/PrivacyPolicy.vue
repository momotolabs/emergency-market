<script setup>
import { Default as DefaultLayout } from "@/Client/Layouts";
import LandingFooter from '@/Client/Components/Landing/Footer.vue'
</script>
<template>
  <DefaultLayout>
    <div class="max-w-[1200px] mx-auto mt-[10%] text-justify md:pt-[4rem] px-3 md:px-[4.5rem]">
      <div class="pt-[3rem] md:px-[6rem]">

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
.table {
  @apply w-full my-[20px];
}
.table td, .table th {
  @apply p-[10px] border border-[#dddddd];
}
</style>
