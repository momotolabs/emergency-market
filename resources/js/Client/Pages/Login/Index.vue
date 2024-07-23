<script setup>
import { ref } from "vue";
import { useForm } from '@inertiajs/inertia-vue3';
import { useVuelidate } from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import { Default as DefaultLayout } from "@/Client/Layouts";
import { Card, CardHeader } from "@/Client/Components/Shared";
import { Input, Button } from "@/Client/Components/Form";

const props = defineProps(['status']);

const inputs = useForm({
  email: "",
  password: "",
});

const rules = {
  email: { required, email },
  password: { required },
};

const $externalResults = ref({});

const v$ = useVuelidate(rules, inputs, { $externalResults });

const submit = async () => {
  $externalResults.value = {};
  const validate = await v$.value.$validate();

  if (!validate) {
    // Notification of validation error
    return false;
  }

  inputs.post(route('login.store'), {
    onError: (errors) => {
      // Notification of validation error
      $externalResults.value = errors;
    },
  });
};
</script>

<template>
  <DefaultLayout>
    <Card>

      <template #header>
        <CardHeader title="Login" ></CardHeader>
        <p class="my-4 font-medium text-sm text-green-600" v-if="props.status">{{ props.status }}</p>
      </template>

      <form @submit.prevent="submit" class="space-y-4">
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

        <div>
          <Link
              :href="route('forgot-password')"
              class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
              Forgot your password?
          </Link>
        </div>

        <Button :loading="inputs.processing">Submit</Button>
      </form>
    </Card>
  </DefaultLayout>
</template>
