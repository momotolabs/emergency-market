<script setup>
import { Default } from '@/Client/Layouts'
import { Button } from '@/Client/Components/Form'
import { Card } from '@/Client/Components/Shared'
import { ResourcesTable, ContractContent } from '@/Client/Components/Shared/Contract'
import dayjs from 'dayjs';

const props = defineProps(['contract', 'resources', 'city', 'state', 'slug','company','owner'])
console.log('mi', props);
</script>

<template>
  <Default>
    <div class="shadow-lg p-4 rounded-md max-w-7xl mx-auto mb-5 min-h-[100px]">
      <template v-if="props.contract == null">
        <h2 class="font-inter font-medium text-2xl">
          This provider does not have an active contract
        </h2>
      </template>

    <template v-else>
      <ContractContent :content="props.contract?.content" />

      <div class="float-right py-10"
        :class="[ props.resources.length < 18 ? 'w-max' : 'w-full' ]"
      >
        <h3 class="text-lg font-semibold">Resources and pricing</h3>
        <ResourcesTable :resources="props.resources" :item-value="{
          name: 'resource.name',
          cents: 'price_cents',
          minimum: 'minimum_units',
        }" />
      </div>

      <form @submit.prevent="submit" class="clear-both">
        <div class="grid grid-cols-2 gap-10 mb-4">

          <div class="space-y-6">
            <div class="flex flex-col">
              <Input label="Homeowner" v-model="props.contract.owner_signed" :value="props.contract.owner_signed"
                :disabled="true" />
              <span>Authorized Signature To Perform Emergency Work</span>
            </div>

            <div class="flex flex-col">
              <input type="text" :value="props.contract.owner_signed"
                class="text-black border-none bg-input-background rounded-md" disabled>
              <span>Printed name and title</span>
            </div>

            <div class="grid grid-cols-2">
              <div class="flex flex-row flex-nowrap space-x-4">
                <p class="m-0">Date signed:</p>
                <span class="border-b-2 border-gray-300">
                  {{ dayjs(props.contract.created_at).format("MM/DD/YYYY") }}
                </span>
              </div>

            </div>
          </div>
          <div>
            <div class="flex flex-col">
              <Label :label="props.company?.name" />
              <input type="text"
                :value="`${props.owner?.first_name} ${props.owner?.last_name}`"
                class="text-black border-none bg-input-background rounded-md" disabled>
            </div>
            <div class="flex flex-row flex-nowrap space-x-4">
              <p class="m-0">Phone number:</p>
              <span class="border-b-2 border-gray-300"> {{ props.company?.phone }}</span>
            </div>
          </div>

        </div>
        <div class="w-[50%] mx-auto my-5">
          <Button
          @click="$inertia.get(route('directory.hire', { state: props.state, city: props.city, company:
          props.company.slug
          }))"
          >
            Hire Company
          </Button>
        </div>
      </form>
    </template>
    </div>
  </Default>
</template>
