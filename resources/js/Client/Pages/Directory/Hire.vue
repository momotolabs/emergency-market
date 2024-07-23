<script setup>
import { ref } from "vue";
import { Default } from "@/Client/Layouts/";
import { useForm } from "@inertiajs/inertia-vue3";
import { Card } from "@/Client/Components/Shared";
import { StartIcon } from "@/Client/Components/Icons";
import { Checkbox, Button, Input, Map } from "@/Client/Components/Form";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, email } from '@vuelidate/validators';

const props = defineProps(['company', 'avatar']);

const acceptOne = ref(false);
const acceptTwo = ref(false);
const acceptThree = ref(false);
const step = ref(1);

const inputs = useForm({
  first_name: "",
  last_name: "",
  phone: "",
  insurance_company: "",
  claim_number: "",
  email: "",
  company_id: null,
  address: "",
  latitude: null,
  longitude: null
});

const rules = {
  first_name: { required },
  last_name: { required },
  phone: { required, minLength: minLength(10) },
  insurance_company: { required },
  claim_number: { required },
  email: { required, email },
  address: { required },
}
const $externalResults = ref({})

const v$ = useVuelidate(rules, inputs, { $externalResults });

const submit = async () => {
  $externalResults.value = {}
  const validate = await v$.value.$validate();

  if(!validate){
    return ;
  }

  inputs.post(route('directory.contract.store', [props.company.id]), {
    onError(errors){
      $externalResults.value = errors
    }
  })
};
</script>

<template>
  <Default>
    <div class="bg-white shadow-lg rounded-lg px-8 py-10 font-inter">
      <div class="border-b border-gray-300 pb-4 space-y-4 md:space-y-0">
        <div class="flex flex-row around items-center space-x-4">
          <img v-if="props.avatar" :src="props.avatar.path" alt="" class="w-20" />
          <div>
            <span>{{ props.company.name }}</span>
            <div class="flex flex-row space-x-2">
              <StartIcon />
              <span>/5 (reviews)</span>
            </div>
          </div>
        </div>
      </div>

      <div class="shadow-lg rounded-lg px-7 py-8 space-y-2" v-if="step === 1">
        <h2 class="text-xl font-medium">
          During emergency conditions, job backlogs change continually and
          emergency resources become in high demand.
        </h2>
        <Checkbox v-model="acceptOne">
          <template #label>
            <p class="m-0">
              Before signing a contract please verify that you have contacted
              the service provider and spoke with this company about their
              ability and timing to handle your job.
            </p>
          </template>
        </Checkbox>
        <Checkbox v-model="acceptTwo">
          <template #label>
            <p class="m-0">
              Also, please verify you have not filled out any other contracts
              with any other company through emergency Market. (Or if you have,
              that the company has been notified but they no longer have the
              job. In other words, we don’t want two different companies double
              booking your job.)
            </p>
          </template>
        </Checkbox>
        <Checkbox v-model="acceptThree">
          <template #label>
            <p class="m-0">
              I agree to use electronic records and signatures.
            </p>
          </template>
        </Checkbox>

        <Button :disabled="!acceptOne || !acceptTwo || !acceptThree" @click="step = 2" :loading="inputs.processing">
          Proceed
        </Button>
      </div>

      <div v-else>
        <Card>
          <form @submit.prevent="submit" class="space-y-4">
            <Input
              placeholder="Write here"
              label="First name (Insured)"
              name="First name"
              v-model="inputs.first_name"
              :error-message="v$.first_name.$errors"
            />
            <Input
              placeholder="Write here"
              label="Last name (Insured)"
              name="First name"
              v-model="inputs.last_name"
              :error-message="v$.last_name.$errors"
            />

            <Map
              required
              placeholder="Write here"
              label="Physical address"
              name="Physical address"
              v-model:lat="inputs.latitude"
              v-model:lng="inputs.longitude"
              v-model:direction="inputs.address"
            />

            <Input
              placeholder="Write here"
              label="Insurance company name"
              name="Insurance company name"
              v-model="inputs.insurance_company"
              :error-message="v$.insurance_company.$errors"
            />
            <Input
              placeholder="Write here"
              label="Claim number"
              name="Claim number"
              v-model="inputs.claim_number"
              :error-message="v$.claim_number.$errors"
            />
            <Input
              placeholder="Write here"
              label="Email address"
              name="Email address"
              v-model="inputs.email"
              :error-message="v$.email.$errors"
            />
            <Input
              placeholder="Write here"
              label="Phone Number"
              name="Phone Number"
              v-model="inputs.phone"
              :error-message="v$.phone.$errors"
            />

            <Button :loading="inputs.processing"> Proceed </Button>
          </form>
        </Card>
      </div>
    </div>
  </Default>
</template>
