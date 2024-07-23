<script setup>
import { ref } from 'vue'
import { Default } from '@/Client/Layouts'
import { StartIcon, CommentIcon } from '@/Client/Components/Icons'
import { Link } from '@inertiajs/inertia-vue3'
const props = defineProps(['companies'])

const tableHeads = ref(['Company', 'Reviews', 'State', 'City'])

</script>

<template>
  <Default>
    <h2 class="text-3xl text-left font-inter font-medium">Directory</h2>
    <p class="mb-14 text-base">
      Below you'll find the emergency market participants in your area. Please feel free to browse their profiles and contracts
    </p>

    <div class="bg-white shadow-lg rounded-lg p-5 overflow-x-auto">
      <table class="w-[150vw] md:w-full font-inter">
        <thead>
          <tr class="bg-white font-semibold border-b-2 border-gray-300 text-xl">
            <td
              v-for="head in tableHeads"
              class="py-4"
            >
              {{ head }}
            </td>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in props.companies"
            :key="index"
            class="border-b-2 border-gray-300"
          >
            <td class="py-4">
              <!-- <Link
                :href="`directory/${item.state}/${item.city}/${item.reviews}`"
              > -->
              <Link
                :href="route('directory.contract', { state: item.city.state.iso_code, city: item.city.slug, company:
                 item.slug })"
              >
                <div class="flex flex-row space-x-4 items-center">
                  <img
                    v-if="item.multimedia.lenght > 0"
                    :src="item.multimedia[0]['path']"
                    :alt="`image of ${item.name}`"
                    class="rounded-full w-20"
                  >
                  <span>{{ item.name }}</span>
                </div>
              </Link>
            </td>
            <td class="py-4">
              <div class="flex flex-col">
                <div class="flex flex-row space-x-2">
                  <CommentIcon />
                  <span>reviews</span>
                </div>
                <div class="flex flex-row space-x-2">
                  <StartIcon />
                  <span>0 reviews</span>
                </div>
              </div>
              <!-- {{ item.reviews }} -->
            </td>
            <td class="py-4">
              {{ item.city.state.name }}
            </td>
            <td class="py-4">
              {{ item.city.name }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </Default>
</template>
