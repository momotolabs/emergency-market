<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import { Nav } from '@/Client/Components/Landing/Pieces/index.js'

const headerNavItems = ref([
  { anchor: '#benefits', anchorTitle: 'Benefits' },
  { anchor: '#services', anchorTitle: 'Services' },
  { anchor: '#about-us', anchorTitle: 'About Us' },
  { anchor: '#our-purpose', anchorTitle: 'Our Purpose' },
  { anchor: '#reviews', anchorTitle: 'Reviews' },
])

const navbarRef = ref()

const showNavbarMobile = () => {
  if (navbarRef.value) navbarRef.value.classList.toggle('!translate-x-0');
}
</script>

<template>
  <header
    class="bg-white h-20 shadow-[0px_32px_64px_rgba(0,0,0,0.25)] flex justify-between items-center px-10 fixed left-0 top-0 w-full z-50 md:h-[100px] md:px-[140px]"
  >
    <Link :href="route('home')">
      <img
        src="@/Client/assets/images/emergency-logo-beta.svg"
        class="h-[70px] md:h-[130px]"
        alt="emergency's Logo"
      />
    </Link>

    <nav
      class="h-[calc(100vh_-_80px)] flex justify-center items-center absolute left-0 top-[80px] w-screen -translate-x-full bg-inherit z-20 shadow-[inset_0_32px_64px_rgba(18,18,18,0.078)]
      transition-transform duration-500 md:relative md:h-max md:top-0 md:left-0 md:transform-none md:justify-end md:shadow-none"
      ref="navbarRef"
      @click="showNavbarMobile">
      <Nav :navItems="headerNavItems" :isHeader="true" />
    </nav>

    <button @click="showNavbarMobile" class="w-6 h-6 md:hidden bg-transparent border-none">
      <img
        src="@/Client/assets/images/Landing/btn-burger.png"
        alt="Toggle button menu"
      />
    </button>
  </header>
</template>
