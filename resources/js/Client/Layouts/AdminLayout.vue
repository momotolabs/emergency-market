<script setup>
import { ref, computed } from 'vue'
import { Notification } from '@/Client/Components/Shared';
import placeholderPicture from '@/Client/assets/admin/avatar-placeholder.png'
import { usePage } from '@inertiajs/inertia-vue3';

const navItems = ref([
  { title: 'Home', anchor: '/dashboard/contracts/open' },
  { title: 'Profile', anchor: '/dashboard/profile' },
])

const containerNavItems = ref([
  { title: 'Profile builder', anchor: '/dashboard/profile' },
  { title: 'Contracts Templates', anchor: '/dashboard/builder' },
  { title: 'Jobs', anchor: '/dashboard/contracts/open' },
  { title: 'Bussiness Support Extras',  anchor: '/dashboard/extras' },
  //{ title: 'Job Breakdown', anchor: '/dashboard/invoices'}
])

const isNavVisible = ref(false)
const companyName = ref('Jill Valentine')

const user = computed(() => usePage().props.value?.auth);
</script>
<template>
  <div>
    <header class="bg-white w-full h-20 flex justify-between items-center px-10 lg:px-[140px]
        fixed top-0 left-0 z-50 shadow-[0_32px_64px_rgba(18,18,18,0.078)]">
      <Link :href="route('home')">
        <img src="@/Client/assets/images/emergency-logo-beta.svg" class="h-[70px] md:h-[80px]" alt="emergency's Logo" />
      </Link>

      <nav class="absolute left-0 top-[80px] h-[calc(100vh_-_80px)] w-screen flex flex-col
          justify-center bg-inherit shadow-[inset_0_32px_64px_rgba(18,18,18,0.078)]
          transition-transform duration-500 md:transform-none md:relative md:h-max md:top-0 md:shadow-none"
        :class="{ 'translate-x-0': isNavVisible, '-translate-x-full': !isNavVisible }"
      >
        <ul
          class="flex flex-col gap-y-8 md:flex-row gap-x-8 text-[#14142a] text-base font-medium p-14 md:p-0 md:justify-end"
        >
          <li v-for="item in navItems">
            <Link :href="item.anchor" class="hover:text-primary"
              :class="{ 'text-primary font-semibold': $page.url === item.anchor }"
            >
              {{ item.title }}
            </Link>
          </li>

          <li>
            <Link :href="route('logout')" method="post" as="button" class="hover:text-primary">
              Logout
            </Link>
          </li>
        </ul>
      </nav>

      <button @click="isNavVisible = !isNavVisible" class="w-6 h-6 absolute top-6 right-4 md:hidden">
        <img src="@/Client/assets/images/Landing/btn-burger.png" alt="Toggle button menu" />
      </button>
    </header>

    <main class="mt-20 px-4 py-12 md:px-[4.5rem]">

      <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4">
        <h1 class="text-base md:text-[32px] font-bold font-inter">Service Provider Dashboard</h1>

        <div class="flex flex-row gap-x-3 items-center">
          <figure>
            <img class="w-[50px] h-[50px]" :src="user.avatar ? user.avatar.path : placeholderPicture" alt="profile picture">
          </figure>
          <span class="text-base font-inter font-medium">{{ user.user.provider_profile.first_name }} {{user.user.provider_profile.last_name}}</span>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-[0_32px_64px_#12121214] p-4 md:p-12">

        <!-- nav by tabs -->
        <nav>
          <ul class="flex flex-row gap-x-10 md:gap-x-16 border-b border-[#c0c0c0] pb-4 text-base font-inter px-10 mb-4 overflow-x-auto">
            <li
              v-for="item in containerNavItems"
              class="min-w-fit"
            >
              <Link :href="item.anchor"
                :class="{ 'text-primary font-semibold': $page.url === item.anchor }"
              >
                {{ item.title }}
              </Link>
            </li>
          </ul>
        </nav>

        <!-- rendeer other pages -->
        <slot />

        <!-- nav container footer -->
        <nav>
          <ul class="flex flex-row text-base font-inter justify-center md:justify-end gap-x-16 border-y border-[#c0c0c0] py-4">
            <li>
              <Link :href="route('terms-of-service')">Terms of service</Link>
            </li>
            <li>
              <Link :href="route('privacy-policy')">Privacy policy</Link>
            </li>
          </ul>
        </nav>
      </div>
    </main>
    <Notification  />
  </div>
</template>
