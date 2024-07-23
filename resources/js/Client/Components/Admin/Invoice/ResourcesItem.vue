<script setup>
import { Input, Select, Button } from "@/Client/Components/Form";
import { ref, computed, watch } from "vue";

const props = defineProps({
  edit: {
    type: Boolean,
    default: false
  },
  resources: {
    type: Array,
  },
  item: {
    type: Object,
  },
  index: {
    type: [String, Number]
  }
});

const emits = defineEmits(['update', 'remove'])

const total = computed(() => {
  return Number(inputs.value.quantity) * Number(inputs.value.price_cents)
});

const inputs = ref({
  id: props.item.id ?? null,
  autoincrement: props.item.autoincrement,
  resource_id: props.item.resource_id ?? null,
  quantity: props.item.units ?? props.item.quantity ?? props.item.units ?? null,
  price_cents: props.item.price_cents/100 ?? null,
  total: total,
  description: props.item.description ?? null
});
const minQty = ref(props.edit ? (props.resources.find((it) => it.id === props.item.resource_id))?.units : props.item.quantity);

const updatedResource = (id) => {
  const res = props.resources.find((item) => item.id === id)

    inputs.value.quantity = res.units
    minQty.value = res.units
  inputs.value.price_cents = res.price_cents / 100
}

const remove = () => {
  emits('remove', props.index);
}


watch(inputs, () => {
  emits('update', { inputs: inputs.value, index: props.index})
}, {deep: true})
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-6 gap-5 mt-5 pb-2 border-b">
    <Select label=""
      class="col-span-1 md:col-span-3"
      placeholder="Select resource"
      :options="props.resources"
      v-model="inputs.resource_id"
      @changed="updatedResource"
      item-text="pricing_resources.resource.name"
    />
    <div>
      <Input label="" :min="minQty" class="col-span-1 md:col-span-1" v-model.number="inputs.quantity" type="number" />
      <span class="text-sm text-gray-500">Min QTY for this resource: <strong>{{minQty}}</strong></span>
    </div>
    <Input label="" class="col-span-1 md:col-span-1" v-model="inputs.price_cents" disabled />
    <Input label="" class="col-span-1 md:col-span-1" v-model="inputs.total" disabled />
    <!--  -->
    <Input label="" class="col-span-1 md:col-span-3" textarea v-model="inputs.description" />
    <span class="col-span-1 md:col-span-2"></span>
    <div  class="col-span-1 md:col-span-1 w-full">
      <div class="w-full flex justify-end">
        <Button type="button" @click="remove">Remove</Button>
      </div>
    </div>
  </div>
</template>
