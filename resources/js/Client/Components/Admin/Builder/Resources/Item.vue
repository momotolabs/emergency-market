<template>
  <tr>
    <td>{{ props.item.resource.resource_name }}</td>
    <td>$ <input v-model="model.price_cents" type="number"> Hr</td>
    <td><input v-model="model.units" type="number" :min="props.item.resource.minimum_units"> Hrs</td>
  </tr>
</template>

<script setup>
import { watch } from 'vue'
const emits = defineEmits(['update'])
const props = defineProps(['item', 'indice'])

const model = ref({
  units: props?.item?.resource.minimum_units,
  price_cents: props?.item?.price_cents / 100,
  price_currency: 'USD',
  pricing_resource_id: props?.item?.pricing_resource_id,
  key: props?.item?.key,
  resource: props.item.resource
})

watch(model, () => {
  emits('update', { model: model.value, index: props.indice })
}, { deep: true })
</script>
