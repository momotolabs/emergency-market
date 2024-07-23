<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

defineProps({
  navItems: {
    type: Array,
    required: true,
  },
  isHeader: {
    type: Boolean,
    required: false,
    default: false,
  },
});
const user = computed(() => usePage().props.value.auth?.user);
</script>

<template>
  <ul class="w-full grid grid-cols-1 gap-8 px-[55px] m-0 md:flex md:flex-row md:w-max md:p-0 md:items-center">
    <li
      v-for="item in navItems"
      class="relative font-bold text-[15px] leading-[18px]"
      :class="{ 'after:w-full after:h-[1px] after:bg-primary after:absolute after:left-0 after:-bottom-5 md:after:content-[none]': isHeader }"
    >
      <Link
        class="hover:!text-primary md:!text-[#14142a] md:text-base font-inter"
        :class="[isHeader ? 'text-primary' : 'text-black']"
        :href="route('home')+item.anchor"
        :external="true"
      >
        {{ item.anchorTitle }}
      </Link>
    </li>
    <template v-if="!user">
      <li
        class="relative mt-[100px] md:mt-0"
        :class="
        { 'after:w-full after:h-[1px] after:bg-primary after:absolute after:left-0 after:-bottom-5 md:after:content-[none]': isHeader,
          'font-medium': isHeader
        }"
      >
        <Link
          class="hover:!text-primary md:!text-[#14142a] md:text-base"
          :class="[isHeader ? 'text-primary' : 'text-black']"
          :href="route('join.index')"
          v-if="isHeader"
        >
          Join
        </Link>
      </li>
      <li
        class="relative"
        :class="
        { 'after:w-full after:h-[1px] after:bg-primary after:absolute after:left-0 after:-bottom-5 md:after:content-[none]': isHeader,
          'font-medium': isHeader
        }"
      >
        <Link
          class="hover:!text-primary md:!text-[#14142a] md:text-base"
          :class="[isHeader ? 'text-primary' : 'text-black']"
          :href="route('login')"
          v-if="isHeader"
        >
          Login
        </Link>
      </li>
    </template>
    <li
      class="relative mt-[100px] md:mt-0"
      :class="
      { 'after:w-full after:h-[1px] after:bg-primary after:absolute after:left-0 after:-bottom-5 md:after:content-[none]': isHeader,
        'font-medium': isHeader
      }"
      v-else
    >
      <Link
        class="hover:!text-primary md:!text-[#14142a] md:text-base"
        :class="[isHeader ? 'text-primary' : 'text-black']"
        :href="route('dashboard.contracts.open')"
        v-if="isHeader"
      >
        Dashboard
      </Link>
    </li>
  </ul>
</template>
