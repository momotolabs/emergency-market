<script setup>
import { Default } from '@/Client/Layouts'

const props = defineProps({
  contract: {
    type: Object,
  },
});

console.log('ss', props.contract);
</script>

<template>
  <Default>
    <div class="shadow-lg p-12 rounded-md max-w-7xl mx-auto">
      <h2 class="text-[#000000d9] font-medium text-xl">This is your confirmation. We have now emailed (and texted) your contract to the tree service.</h2>
      <p class="m-0 text-sm text-[#000000d9] mb-4">Also, their direct number is: {{ props.contract.contract.company.phone }}</p>
      <p class="m-0 text-sm text-[#000000d9] mb-4">Also if you would like to download this contract, you can do so here, however we have also emailed it to you as well.</p>
      <p class="m-0 text-sm text-[#000000d9] mb-4">
        Thanks! <br>
        emergency Market Team
      </p>
      <Link :href="route('directory.index')" class="text-[#1890ff] text-base">
        Go back
      </Link>
      <div class="my-5 text-center">
        <a
          :href="route('directory.contract.complete', { id: props.contract.id })"
          class="bg-primary text-white px-4 py-1 rounded-md font-medium text-lg">
          Download contract
        </a>
      </div>
    </div>
  </Default>
</template>
