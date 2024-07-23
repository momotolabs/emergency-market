<script setup>
import { Default } from "@/Client/Layouts";
import { VueSignaturePad } from "vue-signature-pad";
import {
  ContractContent,
  ResourcesTable,
} from "@/Client/Components/Shared/Contract";
import { NotificationAlert } from "@/Client/Components/Shared";
import { Input, Button, Label } from "@/Client/Components/Form";
import { useForm } from "@inertiajs/inertia-vue3";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { ref } from "vue";
import dayjs from 'dayjs';

const signaturePad = ref();
const contractcontent = ref();

const props = defineProps({
  contract: {
    type: Object,
  },
});

const inputs = useForm({
  owner_signed: null,
  content: props.contract.content,
  owner_signed_image: null
});

const rules = {
  owner_signed_image: { required },
};

const $externalResults = ref({});

const v$ = useVuelidate(rules, inputs, { $externalResults });

const updateContent = (content) => {
  inputs.content = content;
};

const showNotification = ref(false)

const submit = async () => {
  showNotification.value = false
  const signedComplete = await contractcontent.value.getDatos();

  if(!signedComplete){
    showNotification.value = true
    return ;
  }

  inputs.content = signedComplete;


  const { isEmpty, data } = signaturePad.value.saveSignature();
  inputs.owner_signed_image = data;

  const validate = await v$.value.$validate();

  if (!validate) {
    return;
  }


  inputs.put(route("directory.contract.sign", props.contract.id), {
    onError(errors) {
      $externalResults.value = errors;
    },
  });
};

const clearSignature = () => {
  signaturePad.value.clearSignature();
}
</script>

<template>
  <Default>
    <div v-if="props.contract.signed_at">
      This contract is in process
    </div>

    <div class="shadow-lg p-4 rounded-md max-w-7xl mx-auto" v-else>
      <ContractContent
        signing
        :content="props.contract.content"
        :data="{
          ...props.contract.insured,
          phone_number: props.contract.insured.phone,
          date: dayjs().format('MM/DD/YYYY'),
        }"
        @replaced="updateContent"
        ref="contractcontent"
      />

      <div
        class="float-right py-10"
        :class="[
          props.contract.insured_resources.length < 18 ? 'w-max' : 'w-full',
        ]"
      >
        <h3 class="text-lg font-semibold">Resources and pricing</h3>
        <ResourcesTable
          :resources="props.contract.insured_resources"
          :item-value="{
            name: 'pricing_resources.resource.name',
            cents: 'price_cents',
            minimum: 'units',
          }"
        />
      </div>

      <form @submit.prevent="submit" class="clear-both">
        <div class="grid grid-cols-2 gap-10 mb-4">
          <div class="space-y-6">
            <div class="flex flex-col">
              Homeowner
              <VueSignaturePad
                class="border-2"
                width="100%"
                height="200px"
                ref="signaturePad"
              />
              <button @click="clearSignature" type="button" class="bg-gray-300 font-bold py-2">Clear Signature</button>
              <!-- <Input label="Homeowner" v-model="inputs.owner_signed" :error-message="v$.owner_signed.$errors" /> -->
              <span>Authorized Signature To Perform Emergency Work</span>
            </div>

            <div class="flex flex-col">
              <input
                type="text"
                :value="`${props.contract.insured.first_name} ${props.contract.insured.last_name}`"
                class="text-black border-none bg-input-background rounded-md"
                disabled
              />
              <span>Printed name and title</span>
            </div>

            <div class="grid grid-cols-2">
              <div class="flex flex-row flex-nowrap space-x-4">
                <p class="m-0">Date signed:</p>
                <span class="border-b-2 border-gray-300">{{
                  dayjs(props.contract.created_at).format("MM/DD/YYYY")
                }}</span>
              </div>
              <div class="flex flex-row flex-nowrap space-x-4">
                <p class="m-0">Phone number:</p>
                <span class="border-b-2 border-gray-300">
                  {{ props.contract.contract.company.phone }}</span
                >
              </div>
            </div>
          </div>

          <div>
            <div class="flex flex-col">
              <Label :label="props.contract.contract.company.name" />
              <input
                type="text"
                :value="`${props.contract.contract.company.user.provider_profile.first_name} ${props.contract.contract.company.user.provider_profile.last_name}`"
                class="text-black border-none bg-input-background rounded-md"
                disabled
              />
            </div>
          </div>
        </div>
        <Button :loading="inputs.processing">Accept</Button>
      </form>
    </div>
  </Default>
  <NotificationAlert :notification="{ message: 'Complete all required fields' }" :show="showNotification" />
</template>
