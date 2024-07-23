<script setup>
import { DeleteOutlined } from '@ant-design/icons-vue'
import { ref } from 'vue';
const props = defineProps({
  index: [String, Number],
  item: Object
})

const emits = defineEmits(['update', 'remove'])

const inputs = ref({
  id: props.item.id ?? null,
  autoincremt: props.item.autoincremt,
  type: props.item.type,
  amount: props.item.amount,
  name: props.item.name,
})

const emitUpdate = () => {
  emits('update', { item: inputs.value, index: props.index });
}

const emitRemove = () => {
  emits('remove', props.index)
}
</script>


<template>
  <div class="mt-2">
    <input type="text" class="w-48" placeholder="Name of discount" v-model="inputs.name">
    <select v-model="inputs.type" @input="emitUpdate">
      <option value="$">$</option>
      <option value="%">%</option>
    </select>
    <input type="number" class="w-32" v-model="inputs.amount" @input="emitUpdate">
    <button class="ml-3" type="button" @click="emitRemove">
      <DeleteOutlined class="text-red-600 text-xl" />
    </button>
  </div>
</template>
