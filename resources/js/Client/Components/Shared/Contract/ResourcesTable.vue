<script setup>
import { ref, onMounted } from 'vue'
  const props = defineProps({
    resources: {
      type: Array,
      required: true,
      default: () => []
    },
    itemValue: {
      type: Object,
      required: false,
      default: () => ({
        name: 'resource.name',
        cents: 'price_cents',
        minimum: 'minimum_units'
      })
    }
  })

  const firstTableItems = ref([])
  const secondTableItems = ref([])

  const fillTables = () => {
    if(props.resources.length > 18) {
      firstTableItems.value = props.resources.slice(0, 18)
      secondTableItems.value = props.resources.slice(18, props.resources.length)
    } else {
      firstTableItems.value = props.resources
    }
  }

  onMounted(() => {
    fillTables()
  })
</script>

<template>
<div class="flex flex-row flex-nowrap justify-end space-x-6">
  <table class="w-full border-collapse h-max">
    <thead>
      <tr class="text-base font-semibold space-x-6">
        <td >Name</td>
        <td>Rate per hours</td>
        <td>Min hour</td>
      </tr>
    </thead>
    <tbody class="divide-y-2 divide-gray-300">
      <tr v-for="item in firstTableItems" :key="item.id" class="h-max">
        <td class="py-2">{{  props.itemValue.name.split('.').reduce((acc, part) => acc && acc[part], item) }}</td>
        <td class="py-2">${{ Number(item[props.itemValue.cents]) / 100 }} USD</td>
        <td class="py-2">{{ item[props.itemValue.minimum] }} Hrs</td>
      </tr>
    </tbody>
  </table>
  
  <table class="w-full border-collapse h-max" v-if="secondTableItems.length > 0">
    <thead>
      <tr class="text-base font-semibold space-x-6">
        <td>Name</td>
        <td>Rate per hours</td>
        <td>Min hour</td>
      </tr>
    </thead>
    <tbody class="divide-y-2 divide-gray-300">
      <tr v-for="item in secondTableItems" :key="item.id">
        <td class="py-2">{{  props.itemValue.name.split('.').reduce((acc, part) => acc && acc[part], item) }}</td>
        <td class="py-2">${{ Number(item[props.itemValue.cents]) / 100 }} USD</td>
        <td class="py-2">{{ item[props.itemValue.minimum] }} Hrs</td>
      </tr>
    </tbody>
  </table>
</div>
</template>
