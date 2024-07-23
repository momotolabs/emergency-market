<script setup>
  import { Button } from '@/Client/Components/Form'
  import { Modal } from '@/Client/Components/Shared/Modals'

  const props = defineProps({
    open: Boolean,
    title: {
      type: String,
      default: '¿Estas seguro que quieres cancelar?'
    },
    subtitle: {
      type: String,
      required: false,
    },
  })

  const emits = defineEmits(['close', 'accept'])
</script>

<template>
  <Modal :title="props.title" :subtitle="props.subtitle" :open="props.open" @close="emits('close')">
    <div class="mx-auto mt-3 flex space-x-5">
      <Button @click="emits('close')" type="button">No</Button>
      <Button secundary @click="emits('accept')" type="button">Yes</Button>
    </div>
  </Modal>
</template>
