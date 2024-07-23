<script setup>
import { Default } from '@/Client/Layouts'
import { useForm } from "@inertiajs/inertia-vue3"
import { Input, Button } from '@/Client/Components/Form'

const input = useForm({
  direction: ''
})

const submit = async () => {
  input.get(route('directory.index'))
};
</script>

<template>
  <Default>
    <section class="w-[95%] mx-auto bg-white rounded-md shadow-lg p-[3rem] mt-10">
      <h1 class="font-inter text-[28px] font-medium">Emergency Tree Service Locator</h1>
      <p class="font-inter text-sm">At emergencyNet.work we calculate emergency resource response times in real time.
        Thus, In order to do this we need to know what address you need the emergency response resources allocated to.
      </p>
      <p class="font-inter text-sm">
        Once you enter this address we will be able to show you all available resources as well as their response times.
        Please enter the address where you need emergency resources allocated.
      </p>
      <form @submit.prevent="submit">
        <div class="w-1/2 space-y-7">
          <Input label="Address" placeholder="Write here" v-model="input.direction"/>
          <Button :loading="input.processing">View Directory</Button>
        </div>
      </form>
    </section>
  </Default>
</template>
