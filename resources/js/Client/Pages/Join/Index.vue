<script setup>
import { Default as DefaultLayout } from "@/Client/Layouts";
import { Card, CardHeader, CardAlert } from "@/Client/Components/Shared";
import { Input, Checkbox, Button } from "@/Client/Components/Form";
import { useForm } from "@inertiajs/inertia-vue3";
import { useVuelidate } from "@vuelidate/core";
import { required, email, sameAs } from "@vuelidate/validators";
import { computed, ref } from "vue";

const props = defineProps(["notification"]);

const inputs = useForm({
  provider_profile: {
    first_name: "",
    last_name: "",
  },
  company: { name: "" },
  email: "",
  password: "",
  password_confirmation: "",
  //
  accept: {
    term: false,
    policy: false,
  },
});

const rules = computed(() => {
  return {
    provider_profile: {
      first_name: { required },
      last_name: { required },
    },
    company: { name: { required } },
    email: { required, email },
    password: { required },
    password_confirmation: {
      required,
      sameAsPassword: sameAs(inputs.password, "password"),
    },
  };
});

const $externalResults = ref();

const v$ = useVuelidate(rules, inputs, { $externalResults });

const submit = async () => {
  $externalResults.value = {};

  const validate = await v$.value.$validate();

  if (!validate) {
    return false;
  }

  inputs.post(route("join.store"), {
    onError: (errors) => {
      $externalResults.value = errors;
    },
  });
};
</script>

<template>
  <DefaultLayout>
    <CardAlert v-if="props.notification && props.notification.type === 'alert'">
      <div class="bg-[#fff] md:w-[50%] lg:w-[30%] mx-auto p-5 shadow-md mt-32 rounded-md">
        Welcome to emergency, we have sent you an email to continue with your
        registration
      </div>
    </CardAlert>
    <Card class="mt-28" v-else>
      <template #header >
        <CardHeader
          title="Welcome to emergency Market!  We're excited you're here and hope you find this product very helpful for your business."
          subtitle="To get started, let's get some basic information."
        />
      </template>
      <div>
        <div class="mt-12">
          <form @submit.prevent="submit" class="space-y-4">
            <Input
              label="First name"
              name="First name"
              v-model="inputs.provider_profile.first_name"
              :error-message="v$.provider_profile.first_name.$errors"
            />
            <Input
              label="Last name"
              name="Last name"
              v-model="inputs.provider_profile.last_name"
              :error-message="v$.provider_profile.last_name.$errors"
            />
            <Input
              label="Company name"
              name="Company name"
              v-model="inputs.company.name"
              :error-message="v$.company.name.$errors"
            />
            <Input
              label="Email"
              name="Email"
              v-model="inputs.email"
              :error-message="v$.email.$errors"
            />
            <Input
              label="Password"
              name="Password"
              type="password"
              v-model="inputs.password"
              :error-message="v$.password.$errors"
            />
            <Input
              label="Password confirmation"
              name="Password confirmation"
              type="password"
              v-model="inputs.password_confirmation"
              :error-message="v$.password_confirmation.$errors"
            />
            <Checkbox
              name="Accet term of services"
              v-model="inputs.accept.term"
              required
            >
              <template #label>
                Accept
                <a :href="route('terms-of-service')" class="text-blue-800" target="_blank"
                  >Term of services</a
                >
              </template>
            </Checkbox>
            <Checkbox
              name="Accept Privacy policy"
              v-model="inputs.accept.policy"
              required
            >
              <template #label>
                Accept
                <a :href="route('privacy-policy')" class="text-blue-800" target="_blank"
                  >Privacy policy</a
                >
              </template>
            </Checkbox>
            <Button :disabled="!inputs.accept.policy || !inputs.accept.term" :loading="inputs.processing"
              >Verify Email Address</Button
            >
          </form>
        </div>
      </div>
    </Card>
  </DefaultLayout>
</template>
