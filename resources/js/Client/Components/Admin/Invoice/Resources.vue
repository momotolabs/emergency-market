<script setup>
import { ref, onMounted, computed } from "vue";
import { ResourcesItem } from ".";

const props = defineProps({
  modelValue: Array,
  resources: {
    type: Array,
    required: true
  },
  edit: {
    type: Boolean,
    required: false,
    default: false,
  },
  actualResources: {
    type: Array,
    required: false
  }
});

const value = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})

const emits = defineEmits(['update:modelValue'])
const invoiceResources = ref([])
const autoincrement = ref(0);

const addEmptyResource = () => {
  autoincrement.value++
  value.value.push(
    {
      id: null,
      autoincrement: autoincrement.value,
      resource_id: null,
      quantity: null,
      price_cents: null,
      total: 0,
      description: null
    }
  )
}

onMounted(() => {
  if(props.edit){
    props.actualResources.forEach((item, index) => {
      value.value.push({
        id: item.id,
        autoincrement: index,
        resource_id: item.insured_contract_resource_id,
        quantity: item.quantity,
        price_cents: item.price_cents,
        description: item.description,
      });
    })
  }else{
    addEmptyResource();
  }
})

const updateResource = ({ inputs, index }) => {
  value.value[index] = {
    ...inputs,
    price_cents: inputs.price_cents*100,
  }
};

const removeResource = (index) => {
  value.value.splice(index, 1);
};
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-6 gap-5 border-b-2 font-bold">
    <div class="col-span-3">PRODUCT / SERVICE</div>
    <div class="col-span-1">QTY</div>
    <div class="col-span-1">UNIT PRICE</div>
    <div class="col-span-1">TOTAL</div>
  </div>
  <ResourcesItem
    :edit="props.edit"
    v-for="(item, index) in value"
    :key="item.autoincrement"
    :item="item"
    :index="index"
    :resources="props.resources"
    @update="updateResource"
    @remove="removeResource"
  ></ResourcesItem>
  <div class="mt-10">
    <button type="button" class="bg-green-500 py-2 px-4 rounded text-white" @click="addEmptyResource">+ Add item</button>
  </div>
</template>
