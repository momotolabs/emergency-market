<script setup>
  import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
    DialogDescription,
  } from '@headlessui/vue'

  const props = defineProps({
    open: Boolean,
    title: {
      type: String,
    },
    subtitle: {
      type: String,
      required: false,
    },
  })
  const emits= defineEmits(['close'])
</script>

<template>
  <TransitionRoot appear :show="props.open" as="template">
    <Dialog :open="props.open" @close="emits('close')" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>
      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel class="bg-gray-200 text-gray-700 px-10 py-5 rounded">
              <DialogTitle class="font-bold">
                <slot name="title">
                  {{ props.title}}
                </slot>
              </DialogTitle>
              <DialogDescription>
                <slot name="subtitle">
                  {{ props.subtitle }}
                </slot>
              </DialogDescription>

              <slot />
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>


    </Dialog>
  </TransitionRoot>
</template>
