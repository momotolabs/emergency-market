<script setup>
import { AdminLayout } from "@/Client/Layouts";
import { Input } from "@/Client/Components/Form";
import dayjs from 'dayjs';
import {
  ContractContent,
  ResourcesTable,
} from "@/Client/Components/Shared/Contract";

const props = defineProps([
  "contract",
  "resources",
  "company",
  "provider",
  "insured",
]);
</script>
<template>
  <AdminLayout>
    <div class="shadow-lg p-4 rounded-md max-w-7xl mx-auto mb-5">
      <ContractContent
        :content="props.contract.finish_content ?? props.contract?.content"
        :data="{
          ...props.insured,
          phone_number: props.insured.phone,
          date: dayjs(props.contract.signed_at).format('MM/DD/YYYY'),
        }"
      />
      <!-- <div class="float-right py-10"
        :class="[ props.resources.length < 18 ? 'w-max' : 'w-full' ]"
      >
        <h3 class="text-lg font-semibold">Resources and pricing</h3>
        <ResourcesTable
          :resources="props.resources"
          :item-value="{
            name: 'resource.name',
            cents: 'price_cents',
            minimum: 'minimum_units',
          }"
        />
      </div> -->

      <form @submit.prevent="submit" class="clear-both">
        <div class="grid grid-cols-2 gap-10 mb-4">
          <div class="space-y-6">
            <div class="flex flex-col">
              <img :src="props.contract.insured_signature?.signature" width="500px" height="200px">
              <span>Authorized Signature To Perform Emergency Work</span>
            </div>

            <div class="flex flex-col">
              <input
                type="text"
                :value="`${props.provider.first_name} ${props.provider.last_name}`"
                class="text-black border-none bg-input-background rounded-md"
                disabled
              />
              <span>Printed name and title</span>
            </div>

            <div class="grid grid-cols-2">
              <div class="flex flex-row flex-nowrap space-x-4">
                <p class="m-0">Date signed:</p>
                <span class="border-b-2 border-gray-300">
                  {{ props.contract.created_at }}
                </span>
              </div>
            </div>
          </div>

          <div>
            <div class="flex flex-col">
              <Label :label="props.company?.name" />
              <input
                type="text"
                :value="props.company.name"
                class="text-black border-none bg-input-background rounded-md"
                disabled
              />
            </div>
            <div class="flex flex-row flex-nowrap space-x-4">
              <p class="m-0">Phone number:</p>
              <span class="border-b-2 border-gray-300">
                {{ props.company?.phone }}</span
              >
            </div>
          </div>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
