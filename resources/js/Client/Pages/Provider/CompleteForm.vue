<script setup>
import { Default } from "@/Client/Layouts";
import { Card, CardHeader } from "@/Client/Components/Shared";
import { Fieldset, Input, Select, Map, Button } from "@/Client/Components/Form";
import { useForm } from "@inertiajs/inertia-vue3";
import { useVuelidate } from "@vuelidate/core";
import {
  required,
  maxValue,
  minValue,
  minLength,
  url,
  maxLength,
  integer,
  numeric
} from "@vuelidate/validators";
import { ref, computed } from "vue";
import axios from "axios";
const props = defineProps(['me', 'states', 'cities']);

const inputs = useForm({
    address: props.me.company.address,
    city_id: props.me.company.city_id,
    description: props.me.company.description,
    first_time: true,
    google_link: props.me.company.google_link,
    kind: props.me.company.kind,
    miles: props.me.company.miles,
    name: props.me.company.name,
    parking_address: props.me.company.parking_address,
    parking_latitude: props.me.company.parking_coordinates?.coordinates[1],
    parking_longitude: props.me.company.parking_coordinates?.coordinates[0],
    phone: props.me.company.phone,
    state_id: props.me.company.city?.state_id,
    website_link: props.me.company.website_link,
    youtube_link: props.me.company.youtube_link,
    latitude: props.me.company.address_coordinates?.coordinates[1],
    longitude: props.me.company.address_coordinates?.coordinates[0],
    //
    first_name: props.me.provider_profile.first_name,
    last_name: props.me.provider_profile.last_name,
    cellphone: props.me.provider_profile.phone,
});

const rules = computed(() => ({
    city_id: { required },
    state_id: { required },
    description: { required },
    google_link: {  url },
    kind: { required },
    miles: { required, integer, minValue: minValue(1), maxValue: maxValue(100) },
    name: { required },
    phone: { required, minLength: minLength(10), maxLength: maxLength(10), numeric, integer },
    website_link: { url },
    youtube_link: { url },
    //
    first_name: { required },
    last_name: { required },
    cellphone: { required, minLength: minLength(10), maxLength: maxLength(10), numeric, integer },
}));

const $externalResults = ref({});
const v$ = useVuelidate(rules, inputs, { $externalResults });
const cities = ref(props.cities)

const getCities = async (param) => {
  const { data } = await axios.get(route('cities', {state: param }));

  cities.value = data;
}

const submit = async () => {
  $externalResults.value = {};
  const validated = await v$.value.$validate();

  if (!validated) return;

  await inputs.put(route('provider.first-time.update'), {
    onError(errors){
      $externalResults.value = errors;
    }
  })
};
</script>

<template>
  <Default>
    <Card class="mt-28">
      <template #header>
        <CardHeader
          title="Fill out the form below to get started"
          subtitle="First let's get a little bit more basic information about your company"
        />
      </template>

      <div>
        <form @submit.prevent="submit" class="block">
          <Fieldset legend="Generals" class="space-y-5">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <Input
                label="First name"
                name="First name"
                v-model="inputs.first_name"
                :error-message="v$.first_name.$errors"
                :key="'input1'"
              />
              <Input
                label="Last name"
                name="Last name"
                v-model="inputs.last_name"
                :error-message="v$.last_name.$errors"
              />
            </div>

            <Input
              label="Company name"
              name="Company name"
              v-model="inputs.name"
              :error-message="v$.name.$errors"
            />
            <Select
              v-model="inputs.kind"
              label="Type of company"
              name="Type of company"
              placeholder="Select type"
              :error-message="v$.kind.$errors"
            >
              <option value="tree_service">Tree service</option>
              <!-- <option value="water_mitigation">Water Mitigation</option>
              <option value="tarping_roofing_and_board_up">Tarping roofing and board up</option> -->
            </Select>
            <Input
              label="Company description"
              name="Company name"
              textarea
              v-model="inputs.description"
              :error-message="v$.description.$errors"
            />
          </Fieldset>

          <Fieldset legend="Contact" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <Input
                label="Office Phone Number"
                name="Office Phone Number"
                v-model="inputs.phone"
                :error-message="v$.phone.$errors"
              />
              <Input
                label="Website"
                name="Website"
                v-model="inputs.website_link"
                :error-message="v$.website_link.$errors"
                :hasUrl="true"
              />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <Select
                v-model="inputs.state_id"
                :error-message="v$.state_id.$errors"
                label="State"
                name="State"
                placeholder="Select state"
                :options="props.states"
                @changed="getCities"
              />
              <Select
                v-model="inputs.city_id"
                :error-message="v$.city_id.$errors"
                :options="cities"
                label="City"
                name="City"
                placeholder="Select city"
              >
              </Select>
            </div>
            <Map
              label="Address"
              placeholder="Enter address"
              v-model:lat="inputs.latitude"
              v-model:lng="inputs.longitude"
              v-model:direction="inputs.address"
            />

            <Input
              label="Link to your google profile (For google reviews)"
              name="Google profile"
              v-model="inputs.google_link"
              :error-message="v$.google_link.$errors"
              :hasUrl="true"
            />
            <Input
              label="Link to your youtube profile"
              name="Youtube profile"
              v-model="inputs.youtube_link"
              :error-message="v$.youtube_link.$errors"
              :hasUrl="true"
            />
          </Fieldset>

          <Fieldset legend="Parkin lot generals" class="space-y-5">
            <Input
              label="Mobile number (person in control of crew)"
              name="Mobile number"
              v-model="inputs.cellphone"
              :error-message="v$.cellphone.$errors"
            />
            <Map
              label="Address you normally park your equipment"
              v-model:lat="inputs.parking_latitude"
              v-model:lng="inputs.parking_longitude"
              v-model:direction="inputs.parking_address"
            />
            <Input
              label="How many miles will you drive to a single Emergency job?"
              name="Miles"
              type="number"
              v-model="inputs.miles"
              :error-message="v$.miles.$errors"
            />
          </Fieldset>

          <div class="flex space-x-4 mt-5">
            <Button secundary type="button"> Back </Button>
            <Button type="submit" :loading="inputs.processing">Next</Button>
          </div>
        </form>
      </div>
    </Card>
  </Default>
</template>
