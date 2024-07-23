<script setup>
import { computed, onMounted, ref } from 'vue';

const emits = defineEmits(['replaced'])

const props = defineProps({
  data: {
    type: Object,
    required: false
  },
  content: {
    type: [String, null],
    required: true,
  },
  signing: {
    type: Boolean,
    required: false,
    default: false
  }
})

const disponiblesValues = ref(props.data ?? {
  first_name: 'First name',
  last_name: 'Last name',
  address: 'Address',
  phone_number: 'Phone number',
  insurance_company: 'Insurance company',
  claim_number: 'Claim number',
  email: 'Email',
  date: 'Date Signed'
})
const inputIndex = ref(0)
const inputContent = ref(0)

const s = ref("23123");

const inputCreator = () => {
  const inputString = `<input type="text" id="data${inputIndex.value}" ref="data${inputIndex.value}" ${props.signing ? '' : 'disabled'} placeholder="Type initials" maxlength="4" style="width: 150px;" />`
  return inputString
}

const signeds = ref([]);
const getDatos = () => {
  const complete = ref(true);
  const finalContent = props.content
    ?.replaceAll('[initials]', () => {
      inputContent.value++
      let valueInput = document.getElementById(`data${inputContent.value}`).value;
      if(!valueInput){
        complete.value = false
      }
      valueInput  = `<span style="background-color: #d7d7d7; font-size: 20px; font-style: oblique; font-weight: bold; padding: 5px; magin: 5px;">${valueInput}</span>`
      signeds.value.push(valueInput)
      return valueInput
    })
    .format(disponiblesValues.value)
  // for (let index = 0; index < inputIndex.value; index++) {
  //   let valueInput = document.getElementById(`data${index}`).value;
  //   if(!valueInput){
  //     complete.value = false
  //   }
  //   signeds.value.push(value)
  // }
  inputContent.value = 0;

  if(complete.value){
    return finalContent
  }

  return false
}

defineExpose({
  getDatos
})

const stringFormat = computed(() => {
  const formatedContent = props.content
    ?.replaceAll('[initials]', () => {
      inputIndex.value++
      return inputCreator()
    })
    .format(disponiblesValues.value)

    emits('replaced', formatedContent);
  return formatedContent
})
</script>

<template>
  <div v-html="stringFormat" class="prose max-w-none"></div>
</template>
