<script setup>
import { ref, watch, onMounted } from 'vue';
import { DiscountItem, TaxItem} from '.'

const props = defineProps({
  edit: {
    type: Boolean,
    default: false,
  },
  subtotal: [Number,null, Object],
  allDiscounts: {
    type: Array,
    required: false,
  }
})

const discounts = ref([])
const taxes = ref([])

onMounted(() => {
  if(props.edit){
    discounts.value = props.allDiscounts.filter(item => item.type === 'discount').map(item => ({
      id: item.id,
      type: item.fee_type === 'discount' ? '$' : '%',
      amount: item.fee_type === 'discount' ? item.amount /100 : item.amount,
      name: item.name
    }))

    taxes.value = props.allDiscounts.filter(item => item.type === 'tax').map(item => ({
      id: item.id,
      type: item.fee_type === 'discount' ? '$' : '%',
      amount:item.fee_type === 'discount' ? item.amount /100 : item.amount,
      name: item.name
    }))
  }

  // totalCalculation()
})

const total = ref(0);
const autoincremt = ref(0)

const addDiscount = () => {
  discounts.value.push({
    autoincremt: autoincremt.value,
    type: '$',
    amount: null,
    name: ''
  })
  autoincremt.value++
}

const updateDiscounts = ({item, index}) => {
  discounts.value[index] = item
  totalCalculation()
}

const removeDiscounts = (index) => {
  discounts.value.splice(index, 1);
  totalCalculation()
}

const addTax = () => {
  autoincremt.value++
  taxes.value.push({
    autoincremt: autoincremt.value,
    name: '',
    type: '$',
    amount: null
  })
}

const updateTaxes = ({item, index}) => {
  taxes.value[index] = item
  totalCalculation()
}

const removeTaxes = (index) => {
  taxes.value.splice(index, 1);
  totalCalculation()
}

const totalDiscounts = ref(0)
const totalTaxes = ref(0)

const totalCalculation = () => {
  total.value = 0
  totalDiscounts.value = 0
  totalTaxes.value = 0
  discounts.value.forEach((item)=> {
    if(item.type === '$'){
      totalDiscounts.value += item.amount
    }else{
      totalDiscounts.value += (item.amount * props.subtotal.value) / 100
    }
  });

  taxes.value.forEach((item)=> {
    if(item.type === '$'){
      totalTaxes.value += item.amount
    }else{
      totalTaxes.value += (item.amount * props.subtotal.value) / 100
    }
  });

  total.value = props.subtotal.value + totalTaxes.value - totalDiscounts.value
}

const getData = () => {
  return {
    total: total.value,
    totalDiscounts: totalDiscounts.value,
    totalTaxes: totalTaxes.value,
    discounts: discounts.value,
    taxes: taxes.value
  }
}

defineExpose({
  getData
})

watch(props, () => {
  totalCalculation()
});
</script>

<template>
  <div class="space-y-2">
    <div class="flex items-center justify-between  border-b">
      <p>Subtotal</p>
      <p>${{props.subtotal}}</p>
    </div>
    <div class="border-b">
      <div class="flex items-center justify-between">
        <p>Discounts</p>
        <p>
          <button type="button" class="appearance-none text-green-500 font-semibold" @click="addDiscount">Add discount</button>
        </p>
      </div>
      <div class="flex flex-col items-end justify-end mb-1">
        <DiscountItem
          v-for="(item, index) in discounts"
          :key="item.autoincremt"
          :index="index"
          :item="item"
          @update="updateDiscounts"
          @remove="removeDiscounts"
        />
      </div>
    </div>
    <div class="border-b">
      <div class="flex items-center justify-between">
        <p>Taxes</p>
        <p>
          <button type="button" class="bg-green-500 py-2 px-4 rounded text-white font-semibold" @click="addTax">Add Tax</button>
        </p>
      </div>
      <div class="flex flex-col items-end justify-end mb-1">
        <TaxItem
          v-for="(item, index) in taxes"
          :key="item.autoincremt"
          :index="index"
          :item="item"
          @update="updateTaxes"
          @remove="removeTaxes"
        />
      </div>
    </div>
    <div class="flex items-center justify-between">
      <p class="font-bold">total</p>
      <p class="font-bold">${{ total }}</p>
    </div>
  </div>
</template>
